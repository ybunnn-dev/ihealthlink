<div class="relative ml-2 group">
    <button @click="showPrivacy = !showPrivacy" type="button" class="focus:outline-none">
        <template x-if="showPrivacy">
            <!-- Eye icon (visible) -->
            <svg viewBox="0 0 16 16" fill="currentColor" class="w-7 h-7 text-sub_blue" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8L3.07945 4.30466C4.29638 2.84434 6.09909 2 8 2C9.90091 2 11.7036 2.84434 12.9206 4.30466L16 8L12.9206 11.6953C11.7036 13.1557 9.90091 14 8 14C6.09909 14 4.29638 13.1557 3.07945 11.6953L0 8ZM8 11C9.65685 11 11 9.65685 11 8C11 6.34315 9.65685 5 8 5C6.34315 5 5 6.34315 5 8C5 9.65685 6.34315 11 8 11Z" />
            </svg>
        </template>
        <template x-if="!showPrivacy">
            <!-- Eye-slash icon (hidden) -->
            <svg viewBox="0 0 16 16" fill="currentColor" class="w-7 h-7 text-normal_font" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M16 16H13L10.8368 13.3376C9.96488 13.7682 8.99592 14 8 14C6.09909 14 4.29638 13.1557 3.07945 11.6953L0 8L3.07945 4.30466C3.14989 4.22013 3.22229 4.13767 3.29656 4.05731L0 0H3L16 16ZM5.35254 6.58774C5.12755 7.00862 5 7.48941 5 8C5 9.65685 6.34315 11 8 11C8.29178 11 8.57383 10.9583 8.84053 10.8807L5.35254 6.58774Z" />
                <path d="M16 8L14.2278 10.1266L7.63351 2.01048C7.75518 2.00351 7.87739 2 8 2C9.90091 2 11.7036 2.84434 12.9206 4.30466L16 8Z" />
            </svg>
        </template>
    </button>

    <!-- Tooltip -->
    <div class="absolute top-full mt-1 left-1/2 -translate-x-1/2 bg-gray-700 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10">
        <span x-text="showPrivacy ? 'Hide' : 'Show'"></span>
        <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-gray-700 rotate-45"></div>
    </div>
</div>