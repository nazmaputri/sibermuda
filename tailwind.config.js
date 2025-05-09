import defaultTheme from 'tailwindcss/defaultTheme'

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
        midnight: '#08072a',
      },
      keyframes: {
        fadeInOut: {
          '0%, 100%': { opacity: 0 },
          '50%': { opacity: 1 },
        },
        'custom-ping': {
          '0%': { transform: 'scale(0)', opacity: '0' },
          '80%': { transform: 'scale(1)', opacity: '1' },
          '100%': { transform: 'scale(1)', opacity: '1' },
        },
        'custom-bounce': {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-20px)' },
        },
        'fade-up': {
          '0%': { transform: 'translateY(20%)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
      },
      animation: {
        'fade-slow': 'fadeInOut 6s ease-in-out infinite',
        'fade-slower': 'fadeInOut 8s ease-in-out infinite',
        'fade-slowest': 'fadeInOut 10s ease-in-out infinite',
        'ping-and-bounce': 'custom-ping 2s ease-out forwards, custom-bounce 4s ease-in-out infinite 2s',
        'fade-up': 'fade-up 2s ease-out forwards',
      },
    },
  },
  plugins: [
    require('tailwind-scrollbar-hide'),
  ],
}
