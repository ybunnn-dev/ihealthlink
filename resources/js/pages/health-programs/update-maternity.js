// Main Modal Element
const updateMaternityModalEl = document.getElementById('update-maternity-modal');

const currentResident = window.enrolledResident.resident;
const basicMaternalRecord = window.enrolledResident.maternityRecord;

const enrolledResident = window.enrolledResident;

const dconsultations = window.enrolledResident.consultations;
const maternityRecord = window.enrolledResident.maternal_record;

const cancelUpdate = document.getElementById('cancel-update-maternity');
// Basic Information Section
const dateOfRegistrationInput = document.getElementById('date-of-reg');
const familyNumberInput = document.getElementById('family-no');
const residentNameInput = document.getElementById('resident-name');
const addressInput = document.getElementById('address');
const socialEconomicStatusSelect = document.getElementById('ses');
const ageInput = document.getElementById('age');
const lmpInput = document.getElementById('lmp');
const edcInput = document.getElementById('edc');
const gpInput = document.getElementById('g-p');

// Prenatal Checkups Section
const prenatalFirstTriInput = document.getElementById('prenatal-1st');
const prenatalSecondTriInput = document.getElementById('prenatal-2nd');
const prenatalThirdTri1Input = document.getElementById('prenatal-3rd-1');
const prenatalThirdTri2Input = document.getElementById('prenatal-3rd-2');

// Immunization Status Section
const td1Input = document.getElementById('td1');
const td2Input = document.getElementById('td2');
const td3Input = document.getElementById('td3');
const td4Input = document.getElementById('td4');
const td5Input = document.getElementById('td5');

// Micronutrient Supplementation
// Iron Sulfate
const ironSulfateAmount1 = document.getElementById('iron-sulfate-amount-1');
const ironSulfateDate1 = document.getElementById('iron-sulfate-date-1');
const ironSulfateAmount2 = document.getElementById('iron-sulfate-amount-2');
const ironSulfateDate2 = document.getElementById('iron-sulfate-date-2');
const ironSulfateAmount3 = document.getElementById('iron-sulfate-amount-3');
const ironSulfateDate3 = document.getElementById('iron-sulfate-date-3');
const ironSulfateAmount4 = document.getElementById('iron-sulfate-amount-4');
const ironSulfateDate4 = document.getElementById('iron-sulfate-date-4');
// Calcium Carbonate
const calciumCarbonateAmount2 = document.getElementById('calcium-carbonate-amount-2');
const calciumCarbonateDate2 = document.getElementById('calcium-carbonate-date-2');
const calciumCarbonateAmount3 = document.getElementById('calcium-carbonate-amount-3');
const calciumCarbonateDate3 = document.getElementById('calcium-carbonate-date-3');
const calciumCarbonateAmount4 = document.getElementById('calcium-carbonate-amount-4');
const calciumCarbonateDate4 = document.getElementById('calcium-carbonate-date-4');
// Iodine Capsule
const iodineCapsuleAmount1 = document.getElementById('iodine-capsule-amount-1');
const iodineCapsuleDate1 = document.getElementById('iodine-capsule-date-1');

// Health Status & Supplementation Section
const fimStatusSelect = document.getElementById('fim-status');
const dewormingDateInput = document.getElementById('deworming');
const bmiInput = document.getElementById('bmi');

// Infectious Disease Surveillance
const syphilisDateInput = document.getElementById('syphilis-date');
const syphilisResultSelect = document.getElementById('syphilis-result');
const hepatitisBDateInput = document.getElementById('hepatitis-b-date');
const hepatitisBResultSelect = document.getElementById('hepatitis-b-result');
const hivDateInput = document.getElementById('hiv-date');
const hivResultSelect = document.getElementById('hiv-result');

// Laboratory Screening
const gestationalDiabetesDateInput = document.getElementById('gestational-diabetes-date');
const gestationalDiabetesResultSelect = document.getElementById('gestational-diabetes-result');
const cbcDateInput = document.getElementById('cbc-date');
const cbcResultSelect = document.getElementById('cbc-result');
const cbcGivenIronSelect = document.getElementById('cbc-given-iron');

// Pregnancy Outcome Section
const dateTerminatedInput = document.getElementById('date-terminated');
const outcomeSelect = document.getElementById('outcome');
const sexSelect = document.getElementById('sex');
const typeOfDeliverySelect = document.getElementById('type-of-delivery');
const birthWeightInput = document.getElementById('birth-weight');

// Place of Delivery
const healthFacilityTypeSelect = document.getElementById('health-facility-type');
const bemmoncCemoncCapableSelect = document.getElementById('bemmonc-cemonc-capable');
const facilityOwnershipSelect = document.getElementById('facility-ownership');
const birthAttendantSelect = document.getElementById('birth-attendant');
const deliveryRemarksTextarea = document.getElementById('delivery-remarks');

// Date and Time of Delivery
const deliveryDateInput = document.getElementById('delivery-date');
const deliveryTimeInput = document.getElementById('delivery-time');

// Post Partum Checkups
const postpartumCheckup24hInput = document.getElementById('postpartum-checkup-24h');
const postpartumCheckup7dInput = document.getElementById('postpartum-checkup-7d');

// Postpartum Micronutrient Supplementation
const postpartumIronAmount1 = document.getElementById('postpartum-iron-amount-1');
const postpartumIronDate1 = document.getElementById('postpartum-iron-date-1');
const postpartumIronAmount2 = document.getElementById('postpartum-iron-amount-2');
const postpartumIronDate2 = document.getElementById('postpartum-iron-date-2');
const postpartumIronAmount3 = document.getElementById('postpartum-iron-amount-3');
const postpartumIronDate3 = document.getElementById('postpartum-iron-date-3');
const postpartumVitaminAAmount = document.getElementById('postpartum-vitamin-a-amount');
const postpartumVitaminADate = document.getElementById('postpartum-vitamin-a-date');

// General Remarks
const generalRemarksTextarea = document.getElementById('general-remarks');


const openUpdateMaternityModalBtn = document.getElementById('update-maternal');


const confirmUpdateMaternityModalEl = document.getElementById('confirm-update-maternity-modal');

// Interactive elements inside the modal
const confirmUpdateCheckbox = document.getElementById('confirm-update-maternity-checkbox');
const cancelUpdateButton = document.getElementById('confirm-update-maternity-cancel');
const submitUpdateButton = document.getElementById('confirm-update-maternity-submit');

const modalOptions = {
    placement: 'center-center',
    backdrop: 'static', 
    closable: false,    
};

const updateMaternityModal = new Modal(updateMaternityModalEl,modalOptions);

const confirmUpdateMaternityModal = new Modal(confirmUpdateMaternityModalEl, modalOptions);

const updateMaternityBtn = document.getElementById('update-maternity-btn');
const printMaternityBtn = document.getElementById('print-maternity-btn');

console.log(dconsultations);

function updateMaternityMeds(consultationTitle, medicineCategory, amountElement, dateElement) {
    const consultation = dconsultations.find(c => c.consultation_title === consultationTitle);

    if (!consultation) {
        amountElement.value = '';
        dateElement.value = '';
       
        return;
    }

    // 2. Sum the quantity of the specified medicine within that consultation
    let totalQuantity = 0;
    if (consultation.medicine_distributions && consultation.medicine_distributions.length > 0) {
        totalQuantity = consultation.medicine_distributions
            .filter(dist => dist.medicine && dist.medicine.category === medicineCategory)
            .reduce((sum, dist) => sum + dist.quantity, 0);
    }

    // 3. Get the updated_at date and format it to YYYY-MM-DD
    const dateOnly = consultation.updated_at ? consultation.updated_at.split('T')[0] : '';

    // 4. Update the input fields in the DOM
    amountElement.value = totalQuantity;
    dateElement.value = dateOnly;
}


function getConsultationDate(title) {
    const consultation = enrolledResident.consultations.find(
        c => c.consultation_title === title
    );
    return consultation && consultation.consultation_date 
        ? consultation.consultation_date.split("T")[0] 
        : "";
}


function calculateBmi(residentData) {
    const healthRecord = residentData?.resident?.basic_health_record;

    if (healthRecord && healthRecord.weight > 0 && healthRecord.height > 0) {
        const weightKg = healthRecord.weight;
        const heightCm = healthRecord.height;
        const heightM = heightCm / 100;

        const bmi = weightKg / (heightM * heightM);

        // Determine BMI category
        let meaning = '';
        if (bmi < 18.5) {
            meaning = 'Underweight';
        } else if (bmi >= 18.5 && bmi < 25) {
            meaning = 'Normal weight';
        } else if (bmi >= 25 && bmi < 30) {
            meaning = 'Overweight';
        } else {
            meaning = 'Obese';
        }

        // Show BMI value with meaning in parentheses
        bmiInput.value = `${bmi.toFixed(2)} (${meaning})`;
    } else {
        bmiInput.value = 'N/A';
    }
}



openUpdateMaternityModalBtn.addEventListener('click', function(){
    const fullName = `${currentResident.firstName} ${currentResident.middleName} ${currentResident.lastName}`;
    const address =  `Household ${currentResident.family.household.id}, ${currentResident.family.household.purok.name}, ${currentResident.family.household.purok.barangay.name}`
    const createdAt = enrolledResident.created_at; 
    const dateOnly = createdAt.split("T")[0];    

    const birthdate = new Date(currentResident.birthdate + "T00:00:00"); // force ISO date
    const today = new Date();

    let age = today.getFullYear() - birthdate.getFullYear();
    const monthDiff = today.getMonth() - birthdate.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
        age--;
    }

    const getTetanusDate = (title) => {
        // Check if the anti_tetanus_enrollment and its consultations exist
        if (!enrolledResident.anti_tetanus_enrollment || !enrolledResident.anti_tetanus_enrollment.consultations) {
            document.getElementById('no-tetanus').classList.remove('hidden');
            return '';
        }
        const consultation = enrolledResident.anti_tetanus_enrollment.consultations.find(c => c.consultation_title === title);
        // Return the date part if found, otherwise return an empty string
        if(!document.getElementById('no-tetanus').classList.contains('hidden')){
            document.getElementById('no-tetanus').classList.add('hidden');
        }
        return consultation && consultation.updated_at ? consultation.updated_at.split('T')[0] : '';
    };

    dateOfRegistrationInput.value = dateOnly;
    residentNameInput.value = fullName;
    familyNumberInput.value = "#" + currentResident.family_id;
    addressInput.value = address;
    socialEconomicStatusSelect.value = currentResident.family.is_indigent === 1 ? "yes" : "no";
    ageInput.value = age;
    gpInput.value = `G${enrolledResident.maternal_record.gravida}P${enrolledResident.maternal_record.para}`;
    lmpInput.value = enrolledResident.maternal_record.last_menstrual_period.split("T")[0];
    edcInput.value = enrolledResident.maternal_record.expected_date_of_confinement.split("T")[0];
    prenatalFirstTriInput.value  = getConsultationDate("Trimester 1");
    prenatalSecondTriInput.value = getConsultationDate("Trimester 2");
    prenatalThirdTri1Input.value = getConsultationDate("Trimester 3 (1)");
    prenatalThirdTri2Input.value = getConsultationDate("Trimester 3 (2)");

    td1Input.value = getTetanusDate("TT1/TD1");
    td2Input.value = getTetanusDate("TT2/TD2");
    td3Input.value = getTetanusDate("TT3/TD3");
    td4Input.value = getTetanusDate("TT4/TD4");
    td5Input.value = getTetanusDate("TT5/TD5");

    const tetanusDates = [
        td1Input.value,
        td2Input.value,
        td3Input.value,
        td4Input.value,
        td5Input.value
    ];

    const filledCount = tetanusDates.filter(v => v && v.trim() !== "").length;

    if (filledCount === 0) {
        fimStatusSelect.value = "no-data";
    } else if (filledCount === 5) {
        fimStatusSelect.value = "fully-immuned";
    } else {
        fimStatusSelect.value = "partially-immuned";
    }

    updateMaternityMeds(
        'Trimester 1',
        'Iron sulfate With Folic Acid',
        ironSulfateAmount1,
        ironSulfateDate1
    );

    updateMaternityMeds(
        'Trimester 1',
        'Iodine',
        iodineCapsuleAmount1,
        iodineCapsuleDate1
    );

    updateMaternityMeds(
        'Trimester 2',
        'Iron sulfate With Folic Acid',
        ironSulfateAmount2,
        ironSulfateDate2
    );

     updateMaternityMeds(
        'Trimester 2',
        'Calcium Carbonate',
        calciumCarbonateAmount2,
        calciumCarbonateDate2
    );

     updateMaternityMeds(
        'Trimester 3 (1)',
        'Calcium Carbonate',
        calciumCarbonateAmount3,
        calciumCarbonateDate3
    );

    updateMaternityMeds(
        'Trimester 3 (1)',
        'Iron sulfate With Folic Acid',
        ironSulfateAmount3,
        ironSulfateDate3
    );

    updateMaternityMeds(
        'Trimester 3 (2)',
        'Iron sulfate With Folic Acid',
        ironSulfateAmount4,
        ironSulfateDate4
    );

    updateMaternityMeds(
        'Trimester 3 (2)',
        'Calcium Carbonate',
        calciumCarbonateAmount4,
        calciumCarbonateDate4
    );

    const dewormingConsultations = dconsultations.filter(consultation =>
        consultation.medicine_distributions &&
        consultation.medicine_distributions.some(dist => dist.medicine && dist.medicine.category === 'Deworming Tablet')
    );

    // 2. Check if any deworming consultations were found
    if (dewormingConsultations.length > 0) {
    
        dewormingConsultations.sort((a, b) => new Date(b.updated_at) - new Date(a.updated_at));

        const mostRecentConsultation = dewormingConsultations[0];

        const dateOnly = mostRecentConsultation.updated_at.split('T')[0];

        dewormingDateInput.value = dateOnly;
    } else {
        dewormingDateInput.value = '';
    }

    calculateBmi(enrolledResident);

    console.log(maternityRecord);

    if(maternityRecord.maternity_screening){
        const maternityScreening = maternityRecord.maternity_screening;
        syphilisDateInput.value = maternityScreening.syphilis_screening_date !== null ? maternityScreening.syphilis_screening_date : '';
        syphilisResultSelect.value = maternityScreening.syphilis_screening_result !== null ? maternityScreening.syphilis_screening_result : '';
        hepatitisBDateInput.value = maternityScreening.hepatitis_b_screening_date !== null ? maternityScreening.hepatitis_b_screening_date : '';
        hepatitisBResultSelect.value = maternityScreening.hepatitis_b_screening_result !== null ? maternityScreening.hepatitis_b_screening_result : '';
        hivDateInput.value = maternityScreening.hiv_screening_date !== null ? maternityScreening.hiv_screening_date : '';
        hivResultSelect.value = maternityScreening.hiv_screening_result !== null ? maternityScreening.hiv_screening_result : '';
        gestationalDiabetesDateInput.value = maternityScreening.gestational_diabetes_screening_date !== null ? maternityScreening.gestational_diabetes_screening_date : '';
        gestationalDiabetesResultSelect.value = maternityScreening.gestational_diabetes_result !== null ? maternityScreening.gestational_diabetes_result : '';
        cbcDateInput.value = maternityScreening.cbc_screening_date !== null ? maternityScreening.cbc_screening_date : '';
        cbcResultSelect.value = maternityScreening.cbc_result !== null ? maternityScreening.cbc_result : '';
        cbcGivenIronSelect.value = maternityScreening.given_iron !== null ? maternityScreening.given_iron : '';
    }

   if (maternityRecord.pregnancy_outcome) {
        const pregnancyOutcome = maternityRecord.pregnancy_outcome;

        // --- Pregnancy Outcome Section ---
        dateTerminatedInput.value = pregnancyOutcome.date_terminated || '';
        outcomeSelect.value = pregnancyOutcome.outcome || '';
        sexSelect.value = pregnancyOutcome.sex || '';
        typeOfDeliverySelect.value = pregnancyOutcome.delivery_type || '';
        birthWeightInput.value = pregnancyOutcome.birth_weight || '';

        // --- Place of Delivery Section ---
        healthFacilityTypeSelect.value = pregnancyOutcome.delivery_place_type || '';
        // Handle the boolean 'is_bemonc_cemonc_capable' (1 for 'yes', 0 or null for 'no')
        bemmoncCemoncCapableSelect.value = pregnancyOutcome.is_bemonc_cemonc_capable === 1 ? "yes" : "no";
        facilityOwnershipSelect.value = pregnancyOutcome.delivery_place_ownership || '';
        birthAttendantSelect.value = pregnancyOutcome.birth_attendant || '';
        deliveryRemarksTextarea.value = pregnancyOutcome.remarks || '';

        // --- Date and Time of Delivery Section ---
        if (pregnancyOutcome.delivery_datetime) {
            // Split the datetime string "YYYY-MM-DD HH:MM:SS" into date and time parts
            const [datePart, timePart] = pregnancyOutcome.delivery_datetime.split(' ');
            
            deliveryDateInput.value = datePart || '';
            // The time part might include seconds, so we slice to get "HH:MM"
            deliveryTimeInput.value = timePart ? timePart.slice(0, 5) : '';
        } else {
            deliveryDateInput.value = '';
            deliveryTimeInput.value = '';
        }
    }

    postpartumCheckup24hInput.value = getConsultationDate("Postpartum (within 24h)");
    postpartumCheckup7dInput.value = getConsultationDate("Postpartum (within 7 days)");

    updateMaternityMeds(
        'Postpartum (1 month)',
        'Iron With Folic Acid',
        postpartumIronAmount1,
        postpartumIronDate1
    );

     updateMaternityMeds(
        'Postpartum (2 months)',
        'Iron With Folic Acid',
        postpartumIronAmount2,
        postpartumIronDate2
    );

     updateMaternityMeds(
        'Postpartum (3 months)',
        'Iron With Folic Acid',
        postpartumIronAmount3,
        postpartumIronDate3
    );

    const vitaminAConsultations = dconsultations.filter(consultation =>
        consultation.medicine_distributions &&
        consultation.medicine_distributions.some(dist => dist.medicine && dist.medicine.category === 'Vitamin A')
    );

    // 2. Check if any Vitamin A consultations were found.
    if (vitaminAConsultations.length > 0) {
        // Sort the consultations to find the most recent one (newest first).
        vitaminAConsultations.sort((a, b) => new Date(b.updated_at) - new Date(a.updated_at));

        // Get the most recent consultation object.
        const mostRecentConsultation = vitaminAConsultations[0];

        // Find the specific Vitamin A distribution within that consultation.
        const vitaminADistribution = mostRecentConsultation.medicine_distributions.find(
            dist => dist.medicine && dist.medicine.category === 'Vitamin A'
        );

        // Extract the date and format it to YYYY-MM-DD.
        const dateOnly = mostRecentConsultation.updated_at.split('T')[0];

        // Get the amount. Assumes the property is named 'quantity'. Change if needed.
        const amount = vitaminADistribution ? vitaminADistribution.quantity : '';

        // Update the input fields with the correct values.
        postpartumVitaminADate.value = dateOnly;
        postpartumVitaminAAmount.value = amount;

    } else {
        // If no Vitamin A consultations were found, clear the input fields.
        postpartumVitaminADate.value = '';
        postpartumVitaminAAmount.value = '';
    }
    
    generalRemarksTextarea.value = maternityRecord.remarks;
    updateMaternityModal.show();
});



cancelUpdate.addEventListener('click', function(){
    updateMaternityModal.hide();
});


const getMaternityPayload = () => {
    // Helper to parse G/P input like "G2P1" into an object { gravida: 2, para: 1 }
    const parseGP = (gpString) => {
        if (!gpString) return { gravida: null, para: null };
        const match = gpString.match(/G(\d+)P(\d+)/i);
        if (match) {
            return {
                gravida: parseInt(match[1], 10),
                para: parseInt(match[2], 10)
            };
        }
        return {
            gravida: null,
            para: null
        };
    };

    const getSelectValue = (selectElement) => {
        const value = selectElement.value;
        const lowerCaseValue = value.toLowerCase();

        // Check for an empty value or placeholder text like "Select..." or "Choose..."
        if (value === '' || lowerCaseValue.startsWith('select') || lowerCaseValue.startsWith('choose')) {
            return null;
        }
        return value;
    };


    // Construct and return the payload object
    return {
        imporantIds: {
            enrolledResidentId: enrolledResident.id,
            programId: enrolledResident.program_id,
            maternalRecordId: enrolledResident.maternal_record.id
        },
        generalInfo: {
            dateOfRegistration: dateOfRegistrationInput.value,
            familyNumber: familyNumberInput.value.replace('#', ''),
            residentName: residentNameInput.value,
            address: addressInput.value,
            isIndigent: socialEconomicStatusSelect.value === 'yes',
            age: parseInt(ageInput.value, 10) || null,
            lmp: lmpInput.value,
            edc: edcInput.value,
            ...parseGP(gpInput.value)
        },
        prenatalCheckups: {
            firstTrimester: prenatalFirstTriInput.value,
            secondTrimester: prenatalSecondTriInput.value,
            thirdTrimesterFirst: prenatalThirdTri1Input.value,
            thirdTrimesterSecond: prenatalThirdTri2Input.value
        },
        immunization: {
            tetanusDiphtheria: {
                td1: td1Input.value,
                td2: td2Input.value,
                td3: td3Input.value,
                td4: td4Input.value,
                td5: td5Input.value
            }
        },
        micronutrientSupplementation: {
            ironSulfate: {
                checkup1: { amount: ironSulfateAmount1.value, date: ironSulfateDate1.value },
                checkup2: { amount: ironSulfateAmount2.value, date: ironSulfateDate2.value },
                checkup3: { amount: ironSulfateAmount3.value, date: ironSulfateDate3.value },
                checkup4: { amount: ironSulfateAmount4.value, date: ironSulfateDate4.value }
            },
            calciumCarbonate: {
                checkup2: { amount: calciumCarbonateAmount2.value, date: calciumCarbonateDate2.value },
                checkup3: { amount: calciumCarbonateAmount3.value, date: calciumCarbonateDate3.value },
                checkup4: { amount: calciumCarbonateAmount4.value, date: calciumCarbonateDate4.value }
            },
            iodineCapsule: {
                checkup1: { amount: iodineCapsuleAmount1.value, date: iodineCapsuleDate1.value }
            }
        },
        healthStatus: {
            fimStatus: getSelectValue(fimStatusSelect),
            dewormingDate: dewormingDateInput.value,
            bmi: bmiInput.value
        },
        labAndDiseaseScreening: {
            infectiousDisease: {
                syphilis: { date: syphilisDateInput.value, result: getSelectValue(syphilisResultSelect) },
                hepatitisB: { date: hepatitisBDateInput.value, result: getSelectValue(hepatitisBResultSelect) },
                hiv: { date: hivDateInput.value, result: getSelectValue(hivResultSelect) }
            },
            laboratory: {
                gestationalDiabetes: { date: gestationalDiabetesDateInput.value, result: getSelectValue(gestationalDiabetesResultSelect) },
                cbc: { date: cbcDateInput.value, result: getSelectValue(cbcResultSelect), givenIron: getSelectValue(cbcGivenIronSelect) }
            }
        },
        pregnancyOutcome: {
            dateTerminated: dateTerminatedInput.value,
            outcome: getSelectValue(outcomeSelect),
            sex: getSelectValue(sexSelect),
            typeOfDelivery: getSelectValue(typeOfDeliverySelect),
            birthWeightKg: parseFloat(birthWeightInput.value) || null
        },
        deliveryInfo: {
            place: {
                healthFacilityType: getSelectValue(healthFacilityTypeSelect),
                isBemmoncCemoncCapable: (() => {
                    const value = getSelectValue(bemmoncCemoncCapableSelect);
                    if (value === 'yes') return 1;
                    if (value === 'no') return 0;
                    return null;
                })(),
                facilityOwnership: getSelectValue(facilityOwnershipSelect),
                birthAttendant: getSelectValue(birthAttendantSelect),
                remarks: deliveryRemarksTextarea.value
            },
            dateTime: {
                date: deliveryDateInput.value,
                time: deliveryTimeInput.value
            }
        },
        postpartumCare: {
            checkups: {
                within24Hours: postpartumCheckup24hInput.value,
                within7Days: postpartumCheckup7dInput.value
            },
            supplementation: {
                iron: {
                    month1: { amount: postpartumIronAmount1.value, date: postpartumIronDate1.value },
                    month2: { amount: postpartumIronAmount2.value, date: postpartumIronDate2.value },
                    month3: { amount: postpartumIronAmount3.value, date: postpartumIronDate3.value }
                },
                vitaminA: {
                    amount: postpartumVitaminAAmount.value,
                    date: postpartumVitaminADate.value
                }
            }
        },
        remarks: {
            general: generalRemarksTextarea.value
        }
    };
};

updateMaternityBtn.addEventListener('click', function(){
    updateMaternityModal.hide();
    confirmUpdateMaternityModal.show();
});

confirmUpdateCheckbox.addEventListener('change', function(){
    submitUpdateButton.disabled = !this.checked;
});

submitUpdateButton.addEventListener('click', async function() {
    const payload = getMaternityPayload();
    submitUpdateButton.disabled = true;

    console.log("Data for UPDATE:", payload);

    try {
        const response = await fetch('/barangay/health-program/maternity/update-maternal-record', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(payload)
        });

        // Handle non-OK HTTP responses (e.g., 400, 404, 500)
        if (!response.ok) {
            let errorMessage = `Server error (${response.status})`;

            try {
                // Try to read the JSON error message if available
                const errorData = await response.json();
                if (errorData.message) {
                    errorMessage = errorData.message;
                }
            } catch {
                // Fallback if not JSON
                const text = await response.text();
                if (text) errorMessage = text;
            }

            throw new Error(errorMessage);
        }

        // Parse success response
        const result = await response.json();
        console.log(result);

        alert(' Maternal record updated successfully!');
        window.location.reload();
    } catch (error) {
        console.error('Error updating maternal record:', error);
        alert(` Failed to update maternal record.\n\nDetails: ${error.message}`);
    } finally {
        // Always re-enable the button
        submitUpdateButton.disabled = false;
    }
});


// Event listener for the PRINT button
printMaternityBtn.addEventListener('click', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Get the latest data from the form by calling the helper function
    const payload = getMaternityPayload();

    // Use the Fetch API to send the data to your Laravel backend for PDF generation
    fetch('/barangay/export-maternal', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/pdf',
        },
        body: JSON.stringify(payload)
    })
    .then(response => {
        if (!response.ok) {
            // Try to get more error info from the response body if possible
            return response.text().then(text => { throw new Error(`Network response was not ok: ${text}`) });
        }
        return response.blob();
    })
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `maternal_record_${payload.generalInfo.residentName.replace(/\s/g, '_')}.pdf`;
        document.body.appendChild(a);
        a.click();
        a.remove();
        window.URL.revokeObjectURL(url);
    })
    .catch(error => {
        console.error('Error exporting PDF:', error);
        alert('Failed to generate PDF. Please check the console for more details and try again.');
    });
});