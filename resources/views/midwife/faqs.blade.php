@section('title', 'iHealthLink | e-Tanong')

<x-app-layout>
    <div class="py-12 px-5"> 
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4">
                {{-- iHealthLink e-Tanong Section --}}
                <div class="p-12 text-center">
                    <div class="flex flex-col items-center justify-center">
                        {{-- Blue Heart with iHealthLink --}}
                        <div class="flex items-center px-1 gap-2">
                            <svg class="w-16 h-16 text-mainblue flex-shrink-0" viewBox="0 0 90 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M51.9356 40.3515L53.3692 43.9599L55.1231 40.496L58.2998 34.2206L60.3291 39.4364L60.7637 40.5517H81.9961L63.7647 57.5917C60.6229 60.528 56.8727 62.5495 52.8945 63.6601C44.0894 66.5725 33.8877 64.7375 26.8428 58.1532L8.01173 40.5517H39.8457L40.3545 39.6923L47.126 28.2489L51.9356 40.3515ZM7.32619 6.84755C17.0951 -2.28239 32.9335 -2.28265 42.7022 6.84755L45.0029 8.99892L47.2969 6.85537C57.0658 -2.27458 72.9042 -2.27483 82.6729 6.85537C91.4744 15.0821 92.3439 27.9135 85.2842 37.0517H63.1572L60.1406 29.2987L58.7197 25.6454L56.9492 29.1425L53.7539 35.4511L49.0635 23.6435L47.7471 20.33L45.9307 23.3983L37.8496 37.0517H4.71974C-2.34671 27.9128 -1.47841 15.0767 7.32619 6.84755ZM74.0010 4.60244C72.8714 3.94228 71.4536 3.98197 70.3828 4.704C68.3681 6.06262 68.5602 9.01338 70.7383 10.1659L71.6865 10.6679C71.8950 10.7782 72.0928 10.9067 72.2783 11.0507L72.9492 11.5712C75.03 13.1867 76.5836 15.3508 77.4180 17.7958L77.9024 19.2138C77.9673 19.4041 78.0145 19.5998 78.0449 19.7977L78.1113 20.2284C78.4751 22.6001 81.2939 23.7962 83.3125 22.4354C84.3704 21.7221 84.8944 20.4725 84.6533 19.2372L84.1406 16.6142C84.0465 16.1322 83.9036 15.6595 83.7129 15.204L83.2529 14.1044C82.2107 11.6147 80.5883 9.38565 78.5137 7.59267L77.8135 6.98818C77.4382 6.66391 77.0330 6.37349 76.6026 6.12197L74.0010 4.60244Z" fill="currentColor"/>
                            </svg>
                            <div class="flex items-center">
                                <span class="text-maingreen font-semibold whitespace-nowrap text-4xl lg:text-3xl">
                                    iHealth
                                </span>
                                <span class="text-mainblue font-semibold whitespace-nowrap text-4xl lg:text-3xl transition-transform duration-300"
                                    :class="{ 'scale-x-0 opacity-0': !open }">
                                    Link
                                </span>
                            </div>
                        </div>
                        {{-- negative top margin to bring it closer --}}
                        <span class="text-3xl font-semibold text-sub_blue -mt-4">e-Tanong</span>
                        <p class="text-xs text-center font-medium text-darkblue mt-4 max-w-md md:whitespace-nowrap">
                            Looking for answers? e-Tanong helps you navigate healthcare information easily.
                        </p>

                        {{-- Search bar --}}
                        <div class="w-full max-w-xl mt-8">
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..."/>
                            </div>
                        </div>

                        {{-- FAQ Items Container --}}
                        <div class="w-full h-full overflow-y-auto space-y-4 mt-6" id="faq-container">
                            {{-- FAQ question cards will be injected here by JavaScript --}}
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript for dynamic content and interactivity --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const manuals = @json($manuals);
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
        });
    </script>
</x-app-layout>