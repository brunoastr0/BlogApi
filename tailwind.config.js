const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "link-colors": "rgba(255, 255, 255, 0.8)",
                primary: "#6016fc",
                secondary: "#fc165b",
                "secondary-light": "#d60f4b",
                success: "#16fcd2",
                muted: "rgba(255, 255, 255, 0.6)",
                default: "rgba(255, 255, 255 , 0.05)",
                "default-hover": "rgba(255, 255, 255 , 0.1)",
                highlight: "#221048",
                "primary-light": "#6016FC",
                dark: "#0B0B22",
            },
            backgroundImage: {
                app: "url('/public/bg.png') ",
            },
        },


    },

    plugins: [require('@tailwindcss/forms')],
};
