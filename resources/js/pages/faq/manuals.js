const manuals = window.manuals;
const faqContainer = document.getElementById('faq-container');
const searchInput = document.getElementById('default-search');
let activeAnswerCard = null;
let displayLimit = 8; // Default display limit
let isShowingAll = false;

// Function to create a question card
function createQuestionCard(item) {
    const questionCard = document.createElement('div');
    questionCard.className = 'bg-f7 p-4 rounded-lg flex justify-between items-center cursor-pointer hover:bg-gray-100 transition-colors duration-200';
    questionCard.setAttribute('data-question-id', item.id);
    questionCard.setAttribute('data-question-text', item.question.toLowerCase());
    questionCard.setAttribute('data-category-text', item.category.toLowerCase());
    questionCard.setAttribute('data-module-text', item.module.module_name.toLowerCase());

    const questionText = document.createElement('span');
    questionText.className = 'text-sub_blue font-medium text-left';
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
function createAnswerCard(item) {
    const answerCard = document.createElement('div');
    answerCard.className = 'answer-card bg-white px-6 py-12 rounded-lg transition-all duration-300 ease-in-out overflow-hidden text-left';
    answerCard.setAttribute('data-answer-for-question-id', item.id);
    answerCard.style.maxHeight = '0';
    answerCard.style.opacity = '0';
    answerCard.style.paddingTop = '0';
    answerCard.style.paddingBottom = '0';
    answerCard.style.marginTop = '0';
    answerCard.style.visibility = 'hidden';

    const moduleName = document.createElement('h3');
    moduleName.className = 'text-lg font-semibold text-sub_blue';
    moduleName.textContent = `Module: ${item.module.module_name}`;

    const categoryTitle = document.createElement('p');
    categoryTitle.className = 'text-sm text-gray-500 mb-4';
    categoryTitle.textContent = `Category: ${item.category}`;

    const answerContent = document.createElement('p');
    answerContent.className = 'text-gray-800 leading-relaxed';
    answerContent.innerHTML = item.content.replace(/\n/g, '<br>');

    answerCard.appendChild(moduleName);
    answerCard.appendChild(categoryTitle);
    answerCard.appendChild(answerContent);

    return answerCard;
}

// Handle click event for a question card
function handleQuestionClick(clickedQuestionCard, item) {
    const currentQuestionId = item.id;
    const arrowSvg = clickedQuestionCard.querySelector('svg');

    if (activeAnswerCard && activeAnswerCard.getAttribute('data-answer-for-question-id') == currentQuestionId) {
        closeAnswerCard(activeAnswerCard, arrowSvg);
        activeAnswerCard = null;
        return;
    }

    if (activeAnswerCard) {
        const previousQuestionCard = faqContainer.querySelector(`[data-question-id="${activeAnswerCard.getAttribute('data-answer-for-question-id')}"]`);
        const previousArrow = previousQuestionCard ? previousQuestionCard.querySelector('svg') : null;
        closeAnswerCard(activeAnswerCard, previousArrow);
    }

    const newAnswerCard = createAnswerCard(item);
    clickedQuestionCard.after(newAnswerCard);
    activeAnswerCard = newAnswerCard;

    setTimeout(() => {
        newAnswerCard.style.maxHeight = newAnswerCard.scrollHeight + 'px';
        newAnswerCard.style.opacity = '1';
        newAnswerCard.style.paddingTop = '1.5rem';
        newAnswerCard.style.paddingBottom = '1.5rem';
        newAnswerCard.style.marginTop = '1rem';
        newAnswerCard.style.visibility = 'visible';
        arrowSvg.style.transform = 'rotate(180deg)';
    }, 10);
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
        arrow.style.transform = 'rotate(0deg)';
    }

    card.addEventListener('transitionend', function handler() {
        if (card.style.maxHeight === '0px') {
            card.remove();
            card.removeEventListener('transitionend', handler);
        }
    });
}

// Filter and display FAQs based on search input
function filterFAQs() {
    const searchTerm = searchInput.value.toLowerCase();
    const allQuestionCards = faqContainer.querySelectorAll('[data-question-id]');
    
    // Close any open answer card when searching
    if (activeAnswerCard) {
        const previousQuestionCard = faqContainer.querySelector(`[data-question-id="${activeAnswerCard.getAttribute('data-answer-for-question-id')}"]`);
        const previousArrow = previousQuestionCard ? previousQuestionCard.querySelector('svg') : null;
        closeAnswerCard(activeAnswerCard, previousArrow);
        activeAnswerCard = null;
    }

    let visibleCount = 0;
    allQuestionCards.forEach(card => {
        const questionText = card.getAttribute('data-question-text');
        const categoryText = card.getAttribute('data-category-text');
        const moduleText = card.getAttribute('data-module-text');
        
        const matches = questionText.includes(searchTerm) || 
                       categoryText.includes(searchTerm) || 
                       moduleText.includes(searchTerm);
        
        if (matches) {
            if (searchTerm === '' && !isShowingAll && visibleCount >= displayLimit) {
                card.style.display = 'none';
            } else {
                card.style.display = 'flex';
                visibleCount++;
            }
        } else {
            card.style.display = 'none';
        }
    });

    updateShowMoreButton();
}

// Create and manage "Show More" button
function updateShowMoreButton() {
    const existingButton = document.getElementById('show-more-btn');
    if (existingButton) existingButton.remove();

    const searchTerm = searchInput.value.toLowerCase();
    if (searchTerm !== '') return; // Don't show button when searching

    const allQuestionCards = faqContainer.querySelectorAll('[data-question-id]');
    if (allQuestionCards.length <= displayLimit) return;

    const showMoreBtn = document.createElement('button');
    showMoreBtn.id = 'show-more-btn';
    showMoreBtn.className = 'mt-4 px-6 py-2 bg-sub_blue text-white rounded-lg hover:bg-blue-700 transition-colors duration-200';
    showMoreBtn.textContent = isShowingAll ? 'Show Less' : 'Show More';
    
    showMoreBtn.addEventListener('click', () => {
        isShowingAll = !isShowingAll;
        filterFAQs();
    });

    faqContainer.appendChild(showMoreBtn);
}

// Initialize FAQs
function initializeFAQs() {
    faqContainer.innerHTML = '';
    manuals.forEach(item => {
        const questionCard = createQuestionCard(item);
        faqContainer.appendChild(questionCard);
    });
    filterFAQs();
}

// Add search event listener
searchInput.addEventListener('input', filterFAQs);

// Initialize by populating question cards
initializeFAQs();
