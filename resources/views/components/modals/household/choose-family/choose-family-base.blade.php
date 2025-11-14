<div id="chooseFamilyModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(1s00%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6 transition-transform duration-300 ease-out scale-95">
            
            <!-- Multi-step content container -->
            <div id="modalStepsContainer" class="grid overflow-hidden">
                @include('components.modals.household.choose-family.step-1')
                <!-- Future steps will be included here -->
                
                @include('components.modals.household.choose-family.step-2')
            </div>

        </div>
    </div>
</div>
@include('components.modals.household.choose-family.choose-family-confirmation')