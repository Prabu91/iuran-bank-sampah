import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "bcol": "#dde5e8",
                "activePrimary": "#425f6d",
                "hoverPrimary": "#2f4157",
                "primary": "#577c8e",
                "text-light": "#eae6e2",
            },
        },
    },

    plugins: [forms],
};
