import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './resources/views/components/*.blade.php'
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#01236B',
                'primary-sidebar': '#338DEB',
                'primary-sidebar-hover': '#85afdb',
                'midnight' : '#08072a',
            },
        },
    },
    plugins: [
        require('tailwind-scrollbar-hide')
    ],
};

