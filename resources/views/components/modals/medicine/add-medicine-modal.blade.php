<!-- Main modal -->
<div id="add-medicine-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6 max-w-[90%]">
            <!-- Modal header -->
            <div class="flex  flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Add Medicine
                </h3>
                <p class="text-sm text-normal_font">Please enter medicine details to proceed.</p>
            </div>
            <!-- Modal body -->
            <form method="POST" action="{{ route('medicines.store') }}">
                @csrf
                <div class="p-4 md:p-5 space-y-4">
                    <div class="grid grid-cols-1 gap-3">

                        <!-- Medicine Name -->
                        <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                            <label for="medicine_name" class="text-sm font-medium text-main_font">MEDICINE NAME</label>
                            <input type="text" name="medicine_name" id="medicine_name" class="border border-gray-300 text-gray-700 rounded-lg p-2" required>
                        </div>

                        <!-- Generic Name -->
                        <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                            <label for="generic_name" class="text-sm font-medium text-main_font">GENERIC NAME</label>
                            <input type="text" name="generic_name" id="generic_name" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                        </div>

                        <!-- Category -->
                        <div class="flex flex-col col-span-1 relative">
                            <label for="category" class="text-sm font-medium text-main_font">CATEGORY</label>
                            <select name="category" id="category" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                                <option value="Medicine">Medicine</option>
                                <option value="Medical Supplies">Medical Supplies</option>
                                <option value="Equipment">Equipment</option>
                            </select>
                        </div>

                        <!-- Form -->
                        <div class="flex flex-col col-span-1 relative">
                            <label for="form" class="text-sm font-medium text-main_font">FORM</label>
                            <select name="form" id="form" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                                <option value="Tablet">Tablet</option>
                                <option value="Capsule">Capsule</option>
                                <option value="Syrup">Syrup</option>
                                <option value="Injection">Injection</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="grid grid-cols-1 gap-1 relative col-span-1">
                            <label for="description" class="text-sm font-medium text-main_font">DESCRIPTION</label>
                            <textarea name="description" id="description" class="border border-gray-300 text-gray-700 rounded-lg p-2 resize-none h-32"></textarea>
                        </div>

                    </div>
                </div>

                <!-- Modal footer -->
                <div class="flex items-center rounded-b gap-3 justify-end pt-3 px-6">
                    <button data-modal-hide="add-medicine-modal" type="button" class="py-2.5 px-5 text-sm font-medium border rounded-lg">Cancel</button>
                    <button type="submit" class="text-white bg-mainblue hover:bg-blue-800 rounded-lg text-sm px-5 py-2.5">Add Medicine</button>
                </div>
            </form>
        </div>
    </div>
</div>

