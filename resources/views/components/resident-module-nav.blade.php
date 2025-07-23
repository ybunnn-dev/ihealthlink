<div class="bg-white rounded-xl p-3 px-6">
    <div class="flex space-x-6">
        <div class="flex flex-col items-center cursor-pointer">
            <a href="{{ route('midwife.households') }}">
                <span class="font-semibold @if(Request::routeIs('midwife.households')) text-sub_blue @else text-gray-500 @endif">Households</span>
                <div class="h-1 w-full @if(Request::routeIs('midwife.households')) bg-sub_blue @else bg-transparent @endif mt-1"></div>
            </a>
        </div>
        <div class="flex flex-col items-center cursor-pointer">
            <a href="{{ route('midwife.residents') }}">
                <span class="font-semibold @if(Request::routeIs('midwife.residents')) text-sub_blue @else text-gray-500 @endif">Residents</span>
                <div class="h-1 w-full @if(Request::routeIs('midwife.residents')) bg-sub_blue @else bg-transparent @endif mt-1"></div>
            </a>
        </div>
    </div>
</div>