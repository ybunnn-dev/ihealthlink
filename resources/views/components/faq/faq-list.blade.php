@forelse($faqs as $faq)
    <div class="bg-white border border-gray-200 rounded-lg p-5 mb-4 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-2">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $faq->module->module_name ?? 'General' }}
                    </span>
                    @if($faq->category)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            {{ $faq->category }}
                        </span>
                    @endif
                </div>
                <h3 class="text-lg font-semibold text-main_font mb-2">
                    {{ $faq->question }}
                </h3>
                <div class="text-sm text-gray-600 prose max-w-none">
                    {!! nl2br(e($faq->content)) !!}
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex items-start space-x-2 ml-4">
                {{-- EDIT BUTTON --}}
                <button type="button" 
                        class="js-edit-faq-btn text-mainblue hover:text-blue-900 transition-colors" 
                        data-faq-id="{{ $faq->id }}" 
                        title="Edit FAQ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                    </svg>
                </button>

                {{-- DELETE BUTTON --}}
                <button type="button" 
                        class="js-delete-faq-btn text-red1 hover:text-red-900 transition-colors" 
                        data-faq-id="{{ $faq->id }}" 
                        title="Delete FAQ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="text-xs text-gray-500 mt-3 pt-3 border-t border-gray-100">
            Added {{ $faq->created_at->diffForHumans() }}
        </div>
    </div>
@empty
    <div class="text-center py-10">
        <img src="{{ asset('images/illustrations/empty.png') }}" alt="No FAQs found" class="mx-auto w-64">
        <p class="mt-5 text-lg font-medium text-gray-700">
            No FAQs found.
        </p>
        <p class="mt-2 text-sm text-gray-500">
            Try adjusting your search or filters.
        </p>
    </div>
@endforelse
