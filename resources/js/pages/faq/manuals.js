
const manuals = window.manuals;
const faqContainer = document.getElementById('faq-container');
let activeAnswerCard = null; // To keep track of the currently open answer card

// Function to create a question card
function createQuestionCard(item) {
    const questionCard = document.createElement('div');
    questionCard.className = 'bg-f7 p-4 rounded-lg flex justify-between items-center cursor-pointer hover:bg-gray-100 transition-colors duration-200';
    questionCard.setAttribute('data-question-id', item.id); // Store ID for linking with answer

    const questionText = document.createElement('span');
    questionText.className = 'text-sub_blue font-medium text-left'; // Added text-left for better alignment
    questionText.textContent = item.question;

    const arrowSvg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    arrowSvg.setAttribute('class', 'w-5 h-5 text-gray-500 transform transition-transform duration-200');
    arrowSvg.setAttribute('fill', 'none');
    arrowSvg.setAttribute('stroke', 'currentColor');
    arrowSvg.setAttribute('viewBox', '0 0 24 24');
    arrowSvg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>';

    questionCard.appendChild(questionText);
    questionCard.appendChild(arrowSvg);

    questionCard.addEventListener('click', () => {
        handleQuestionClick(questionCard, item);
    });

    return questionCard;
}

// Function to create an answer card
// Function to create an answer card
function createAnswerCard(item) {
    const answerCard = document.createElement('div');
    answerCard.className = 'answer-card bg-white px-6 py-12 rounded-lg transition-all duration-300 ease-in-out overflow-hidden text-left';
    answerCard.setAttribute('data-answer-for-question-id', item.id);
    // Use max-height and opacity for smooth slide-down/fade-in animation
    answerCard.style.maxHeight = '0';
    answerCard.style.opacity = '0';
    answerCard.style.paddingTop = '0';
    answerCard.style.paddingBottom = '10';
    answerCard.style.marginTop = '0';
    answerCard.style.visibility = 'hidden';


    const moduleName = document.createElement('h3');
    moduleName.className = 'text-lg font-semibold text-sub_blue'; // Added margin-bottom for spacing
    moduleName.textContent = `Module: ${item.module.module_name}`; // Display the module name

    const categoryTitle = document.createElement('p');
    categoryTitle.className = 'text-sm text-gray-500 mb-4';
    categoryTitle.textContent = `Category: ${item.category}`; // Added "Category: " prefix

    const answerContent = document.createElement('p');
    answerContent.className = 'text-gray-800 leading-relaxed';
    answerContent.innerHTML = item.content.replace(/\n/g, '<br>');


    answerCard.appendChild(moduleName); // Moved moduleName here
    answerCard.appendChild(categoryTitle);
    answerCard.appendChild(answerContent); // Corrected order

    return answerCard;
}

// Handle click event for a question card
function handleQuestionClick(clickedQuestionCard, item) {
    const currentQuestionId = item.id;
    const arrowSvg = clickedQuestionCard.querySelector('svg');

    // If there's an active answer card and it's for the same question, close it.
    if (activeAnswerCard && activeAnswerCard.getAttribute('data-answer-for-question-id') == currentQuestionId) {
        closeAnswerCard(activeAnswerCard, arrowSvg);
        activeAnswerCard = null;
        return; // Exit after closing the same card
    }

    // Close any currently active answer card (if different question)
    if (activeAnswerCard) {
        const previousQuestionCard = faqContainer.querySelector(`[data-question-id="${activeAnswerCard.getAttribute('data-answer-for-question-id')}"]`);
        const previousArrow = previousQuestionCard ? previousQuestionCard.querySelector('svg') : null;
        closeAnswerCard(activeAnswerCard, previousArrow);
    }

    // Create and open the new answer card
    const newAnswerCard = createAnswerCard(item);
    clickedQuestionCard.after(newAnswerCard); // Insert right after the clicked question
    activeAnswerCard = newAnswerCard; // Set the new card as active

    // Animate opening
    setTimeout(() => { // Small delay to allow DOM render before animation
        newAnswerCard.style.maxHeight = newAnswerCard.scrollHeight + 'px';
        newAnswerCard.style.opacity = '1';
        newAnswerCard.style.paddingTop = '1.5rem'; // Revert to initial padding
        newAnswerCard.style.paddingBottom = '1.5rem'; // Revert to initial padding
        newAnswerCard.style.marginTop = '1rem'; // Add margin for spacing
        newAnswerCard.style.visibility = 'visible';
        arrowSvg.style.transform = 'rotate(180deg)'; // Rotate arrow up
    }, 10); // A minimal timeout is often needed for transitions to apply
}

// Function to close an answer card with animation
function closeAnswerCard(card, arrow) {
    if (!card) return;

    card.style.maxHeight = '0';
    card.style.opacity = '0';
    card.style.paddingTop = '0';
    card.style.paddingBottom = '0';
    card.style.marginTop = '0';
    if (arrow) {
        arrow.style.transform = 'rotate(0deg)'; // Rotate arrow down
    }

    // Remove the card from DOM after transition
    card.addEventListener('transitionend', function handler() {
        if (card.style.maxHeight === '0px') { // Ensure it's fully collapsed
            card.remove();
            card.removeEventListener('transitionend', handler);
        }
    });
}

// Initialize by populating question cards
manuals.forEach(item => {
    const questionCard = createQuestionCard(item);
    faqContainer.appendChild(questionCard);
});
