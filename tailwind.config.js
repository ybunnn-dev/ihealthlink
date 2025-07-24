// tailwind.config.js

import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            borderWidth: {
                navboard: '0.5px',
            },
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                nav_active: '#DFEEFF',
                mainblue: '#279EFF',
                main_font: '#566A7F',
                normal_font: "#697A8D",
                maingreen: '#328E6E',
                f7: '#f7f7f7', // This is white, used for contrast
                darkblue: '#1a202c', // New color for background below 1000px if needed, based on screenshot 665095.png
                bg_col: "#ECF0F4",
                sub_blue: "#252F6C",
                col_orange: "#F0BB78",
                col_pink: "#D50B8B",
                col_brown: "#854836",
                col_tab_h: "#DCEBFC",
            },
            fontSize: {
                // More aggressive clamping for better scaling on smaller PC screens
                'fluid-xxs': 'clamp(0.25rem, 0.45vw + 0.7rem, 0.52rem)',
                'fluid-xs': 'clamp(0.45rem, 0.9vw + 0.1rem, 0.75rem)',
                'fluid-sm': 'clamp(0.55rem, 1.1vw + 0.1rem, 0.875rem)',
                'fluid-base': 'clamp(0.65rem, 1.3vw + 0.1rem, 1rem)',
                'fluid-lg': 'clamp(0.75rem, 1.5vw + 0.1rem, 1.125rem)',
                'fluid-xl': 'clamp(0.9rem, 2.5vw + 0.2rem, 2.0rem)',
                'fluid-2xl': 'clamp(1.1rem, 3.0vw + 0.1rem, 2rem)',
                'fluid-logo': 'clamp(1.4rem, 3.5vw + 0.5rem, 4rem)',
                // Font sizes for new breakpoints
                'fluid-slg2': 'clamp(0.8rem, 1.6vw + 0.1rem, 1.2rem)',
                'fluid-lg2': 'clamp(0.85rem, 1.7vw + 0.1rem, 1.25rem)',
                'fluid-lg3': 'clamp(0.9rem, 1.8vw + 0.1rem, 1.3rem)',
                'fluid-xl2': 'clamp(0.95rem, 1.9vw + 0.1rem, 1.35rem)',
                'fluid-xl3': 'clamp(1.0rem, 2.0vw + 0.15rem, 1.4rem)',
                'fluid-xl4': 'clamp(1.05rem, 2.1vw + 0.15rem, 1.5rem)',
            },
            spacing: {
                'fluid-0.5': 'clamp(0.05rem, 0.1vw, 0.25rem)',
                'fluid-1': 'clamp(0.1rem, 0.2vw, 0.5rem)',
                'fluid-2': 'clamp(0.2rem, 0.4vw, 0.9rem)',
                'fluid-3': 'clamp(0.3rem, 0.6vw, 1.2rem)',
                'fluid-card-pad': 'clamp(0.8rem, 2.0vw, 3.5rem)',
                'fluid-gap-col': 'clamp(1rem, 2.5vw, 4rem)',
                'fluid-vert-pad': 'clamp(4rem, 10vh, 8rem)',
                'fluid-form-gap': 'clamp(0.5rem, 1.0vw, 1.8rem)',
                'fluid-logo-top-offset': 'clamp(0.8rem, 2vh, 1.5rem)',
                'fixed-offset-20': '20px',
            },
            maxHeight: {
                'card-max': 'clamp(25rem, 60vh, 28rem)',
            },
            // Custom breakpoints for precise control
            screens: {
                'xs': '475px',    // Extra small screens
                'sm': '640px',    // Small screens
                'md': '768px',    // Medium screens (tablets)
                'slg': '900px',   // Small-large screens
                'slg2': '1000px', // Small-large screens 2
                'lg': '1024px',   // Large screens (desktops, default for multi-column)
                'lg2': '1100px',  // Large screens 2
                'lg3': '1200px',  // Large screens 3
                'xl': '1240px',   // Extra large screens
                'xl2': '1300px',  // Extra large screens 2
                'xl3': '1400px',  // Extra large screens 3
                'xl4': '1500px',  // Extra large screens 4
                '2xl': '1536px',  // 2x extra large screens
            }
        },
    },
    plugins: [
        forms,
        typography,
        require('tailwind-scrollbar-hide'),
    ],
};