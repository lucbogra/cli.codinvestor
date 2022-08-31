const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                grape: colors.purple,
                'warm-gray': colors.warmGray,
                teal: colors.teal,
                // primary: '#0077B6',
                primary : {
                    400 : '#548ECB',
                    500 : '#2F6AB2',
                    600 : '#3C699C',
                    700 : '#0C4687',
                    800 : '#1B2E51'
                },
                secondary: '#0096C7',
                danger : '#F2135D',
                success : '#17C964',
                bluegradient: 'rgb(17,94,182)',
              },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
