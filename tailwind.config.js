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
                primary: {
                    DEFAULT: '#0057D9',
                    50: '#e6f0ff',
                    100: '#cce0ff',
                    200: '#99c2ff',
                    300: '#66a3ff',
                    400: '#3385ff',
                    500: '#0057D9',
                    600: '#0047b3',
                    700: '#00368c',
                    800: '#002566',
                    900: '#001440',
                },
                secondary: {
                    DEFAULT: '#00A651',
                    50: '#e6f9f0',
                    100: '#ccf3e1',
                    200: '#99e7c3',
                    300: '#66dba5',
                    400: '#33cf87',
                    500: '#00A651',
                    600: '#008a43',
                    700: '#006d35',
                    800: '#005127',
                    900: '#003419',
                },
                accent: '#F1F3F5',
            },
        },
    },

    plugins: [forms],
};
