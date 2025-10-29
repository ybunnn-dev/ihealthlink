<div id="edit-faq-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-normal_font py-10 px-6">
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 id="edit-faq-modal-title" class="text-xl font-semibold text-main_font">
                    Edit FAQ
                </h3>
                <p id="edit-faq-modal-subtitle" class="text-sm text-normal_font">Update the details for the user manual entry</p>
            </div>
            
            <div class="p-4 md:p-5 max-h-[60vh] overflow-auto">
                <form class="space-y-6" action="#" id="edit-faq-form">
                    @csrf
                    @method('PUT')
                    
                    <input type="hidden" name="faq_id" id="edit_faq_id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        
                        <div>
                            <label for="edit_module_id" class="block mb-2 text-sm font-medium text-main_font">Module</label>
                            <select id="edit_module_id" name="module_id" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="" disabled>Select a module</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}">{{ $module->module_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="edit_category" class="block mb-2 text-sm font-medium text-main_font">Category</label>
                            <input type="text" name="category" id="edit_category" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="e.g., General, Residents, Reports" required>
                        </div>

                        <div class="md:col-span-2">
                            <label for="edit_question" class="block mb-2 text-sm font-medium text-main_font">Question</label>
                            <textarea id="edit_question" name="question" rows="3" class="resize-none block p-2.5 w-full text-sm text-main_font bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter the full question..." required></textarea>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="edit_content" class="block mb-2 text-sm font-medium text-main_font">Answer / Content</label>
                            <textarea id="edit_content" name="content" rows="6" class="block p-2.5 w-full text-sm resize-none text-main_font bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Provide the detailed answer, steps, or instructions..." required></textarea>
                        </div>
                    </div>
                </form>
            </div>
             <div class="flex items-center justify-between border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-6">
                <button id="editFaqCancelBtn" data-modal-hide="edit-faq-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button id="updateFaqBtn" type="submit" form="edit-faq-form" class="text-white disabled:opacity-50 bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update FAQ</button>
            </div>
        </div>
    </div>
</div>
@include('components.modals.faq.edit-faq-confirm')