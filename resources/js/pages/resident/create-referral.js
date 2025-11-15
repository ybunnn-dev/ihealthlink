// Main Modal Element

// --- Existing Element Variables ---

const createModalOptions = (modalEl) => ({
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            modalEl.classList.remove('opacity-0');
            modalEl.classList.add('opacity-100');

            const modalContent = modalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        modalEl.classList.add('opacity-0');
        modalEl.classList.remove('opacity-100');

        const modalContent = modalEl.querySelector('.relative.bg-white');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
});


const createReferralModalEl = document.getElementById('create-referral-modal');
const confirmCreateReferralModalEl = document.getElementById('confirm-create-referral-modal');
const residentNameConfirm = document.getElementById('create-referral-resident-name-confirm');
const confirmCheckbox = document.getElementById('confirm-create-referral-checkbox');
const cancelCreateReferralBtn = document.getElementById('cancel-confirm-create-referral');
const confirmCreateReferralBtn = document.getElementById('confirm-create-referral-btn');

const referredTo = document.getElementById('referred-to').textContent;
const resident = window.resident;
const family = resident.family;
const household = family.household;
const purok = household.purok;
const now = new Date();

const referredDate = document.getElementById('referred-date');
const referredTime = document.getElementById('referred-time');
const referredFrom = document.getElementById('referred-from');
const referralNeeds = document.getElementById('referral-needs');

const formattedTimeDisplay = document.getElementById('formatted-time'); //exclude this

// Patient Information Section
const patientName = document.getElementById('patient-name');
const patientBirthdate = document.getElementById('patient-birthdate');
const patientAge = document.getElementById('patient-age');
const patientAddress = document.getElementById('patient-address');
const patientSex = document.getElementById('patient-sex');
const civilStatus = document.getElementById('civil-status');
const fatherName = document.getElementById('father-name');
const motherName = document.getElementById('mother-name');
const purokSelect = document.getElementById('purokSelect');

// Vital Signs & Measurements Section
const height = document.getElementById('referral-height');
const weight = document.getElementById('referral-weight');
const temperature = document.getElementById('referral-temperature');
const bpSystolic = document.getElementById('referral-bp-systolic');
const bpDiastolic = document.getElementById('referral-bp-diastolic');
const pulseRate = document.getElementById('referral-pulse-rate');
const respRate = document.getElementById('referral-resp-rate');

// For Female Patients Section
const isPregnant = document.getElementById('is-pregnant');
const fpMethod = document.getElementById('fp-method');
const lmpDate = document.getElementById('lmp-date');
const eddDate = document.getElementById('edd-date');
const gravida = document.getElementById('gravida');
const para = document.getElementById('para');
const aog = document.getElementById('aog');

// For Infants Section
const infantBirthWeight = document.getElementById('infant-birth-weight');

// Medical Details Section
const chiefComplaint = document.getElementById('chief-complaint');
const medicineTaken = document.getElementById('medicine-taken');
const managementDone = document.getElementById('management-done');

// Modal Footer Buttons
const cancelReferralBtn = document.getElementById('cancel-referral-btn');
const printReferralBtn = document.getElementById('print-referral-btn');

const openCreateReferral = document.getElementById('create-referral-open');

const createReferralModal = new Modal(createReferralModalEl, createModalOptions(createReferralModalEl));
const confirmCreateReferralModal = new Modal(confirmCreateReferralModalEl, createModalOptions(confirmCreateReferralModalEl));

openCreateReferral.addEventListener('click', async function () {
    const { firstName, middleName, lastName, suffix } = resident;
    
    // Format date (YYYY-MM-DD) for input type="date"
    referredDate.value = now.toISOString().split('T')[0];

    // Format time for input type="time" (HH:MM)
    const hours24 = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    referredTime.value = `${hours24}:${minutes}`;

    // Display AM/PM formatted version beside the input
    let hours12 = now.getHours();
    const ampm = hours12 >= 12 ? 'PM' : 'AM';
    hours12 = hours12 % 12 || 12; // convert 0 to 12 for 12-hour format
    const formattedTime = `${hours12}:${minutes} ${ampm}`;
    formattedTimeDisplay.textContent = `(${formattedTime})`;

    // Update the display if user changes the time manually
    referredTime.addEventListener('input', () => {
        const [hourStr, minuteStr] = referredTime.value.split(':');
        let hour = parseInt(hourStr);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        hour = hour % 12 || 12;
        formattedTimeDisplay.textContent = `(${hour}:${minuteStr} ${ampm})`;
    });

    const fullName = [
        firstName,
        middleName ? middleName : null,
        lastName,
        suffix ? suffix : null
    ].filter(Boolean).join(' ');

    patientName.value = fullName;
    patientBirthdate.value = resident.birthdate;

    const birthDate = new Date(resident.birthdate);
    const today = new Date();

    // Compute age
    let ageYears = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        ageYears--;
    }

    if (ageYears < 1) {
        let months = (today.getFullYear() - birthDate.getFullYear()) * 12 + (today.getMonth() - birthDate.getMonth());
        if (today.getDate() < birthDate.getDate()) months--;
        patientAge.value = `${months} month${months !== 1 ? 's' : ''} old`;
    } else {
        patientAge.value = `${ageYears} year${ageYears !== 1 ? 's' : ''} old`;
    }

    //  Fetch puroks when button is clicked
    try {
        const response = await fetch('/barangay/get-puroks');
        if (!response.ok) throw new Error('Failed to fetch puroks');
        const data = await response.json();
        
        // Assuming your backend returns an array like [{ id: 1, name: 'Purok 1' }, ...]
        
        purokSelect.innerHTML = ''; // clear old options

        data.puroks.forEach(p => {
            const option = document.createElement('option');
            option.value = p.name;
            option.textContent = p.name;
            purokSelect.appendChild(option);
        });

        console.log('Puroks fetched:', data.puroks);
    } catch (err) {
        console.error('Error fetching puroks:', err);
    }

    referredFrom.value = `${purok.barangay.name}, Daraga, Albay`;
    patientAddress.value = `${purok.name}, ${purok.barangay.name}, Daraga, Albay`;
    patientSex.value = resident.sex;
    civilStatus.value = resident.civil_status;
    
    createReferralModal.show();
});

cancelReferralBtn.addEventListener('click',function(){
    createReferralModal.hide();
});

printReferralBtn.addEventListener('click',function(){
    createReferralModal.hide();
    residentNameConfirm.textContent = patientName.value.trim();
    confirmCreateReferralModal.show();
});

confirmCheckbox.addEventListener('change',function(){
    confirmCreateReferralBtn.disabled = !this.checked;
});

confirmCreateReferralBtn.addEventListener('click', function() {
    // Disable the button to prevent multiple clicks
    this.disabled = true;
    this.textContent = 'Generating...';

    const payload = {
        // Referral Information
        referralInfo: {
            referredDate: referredDate.value,
            referredTime: referredTime.value,
            purok: purokSelect.value,
            referredFrom: referredFrom.value,
            referralNeeds: referralNeeds.value,
        },
        // Patient Information
        patientInfo: {
            name: patientName.value,
            birthdate: patientBirthdate.value,
            age: patientAge.value,
            address: patientAddress.value,
            sex: patientSex.value,
            civilStatus: civilStatus.value,
            fatherName: fatherName.value,
            motherName: motherName.value,
            purok: purokSelect.value,
        },
        // Vital Signs & Measurements
        vitalSigns: {
            height: height.value,
            weight: weight.value,
            temperature: temperature.value,
            bloodPressure: {
                systolic: bpSystolic.value,
                diastolic: bpDiastolic.value,
            },
            pulseRate: pulseRate.value,
            respiratoryRate: respRate.value,
        },
        // For Female Patients
        femalePatientDetails: {
            isPregnant: isPregnant.value,
            fpMethod: fpMethod.value,
            lmpDate: lmpDate.value,
            eddDate: eddDate.value,
            gravida: gravida.value,
            para: para.value,
            aog: aog.value,
        },
        // For Infants
        infantDetails: {
            birthWeight: infantBirthWeight.value,
        },
        // Medical Details
        medicalDetails: {
            chiefComplaint: chiefComplaint.value,
            medicineTaken: medicineTaken.value,
            managementDone: managementDone.value,
        }
    };

    // Send the data to the Laravel backend
    fetch('/export/referral-pdf', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(payload)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.blob(); // Get the PDF as a blob
        })
        .then(blob => {
            // Create a URL for the blob
            const url = window.URL.createObjectURL(blob);
            // Create a temporary link to trigger the download
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            // Sanitize patient name for the filename
            const fileName = (payload.patientInfo.name || 'patient').replace(/[^a-z0-9]/gi, '_').toLowerCase();
            a.download = `referral_form_${fileName}.pdf`;
            document.body.appendChild(a);
            a.click();
            // Clean up
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to generate PDF. Please try again.');
        })
        .finally(() => {
            // Re-enable the button
            this.disabled = false;
            this.textContent = 'Confirm & Create';
        });
});

cancelCreateReferralBtn.addEventListener('click',function(){
    confirmCreateReferralModal.hide();
    createReferralModal.show();
});