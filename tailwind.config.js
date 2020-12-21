const colors = require('tailwindcss/colors')

module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php'
    ],

    theme: {
        extend: {
            colors: {
                rose: colors.rose,
                gray: colors.warmGray
            },
            fontFamily: {
                sans: ['Nunito', 'sans-serif']
            },
            typography: theme => ({
                DEFAULT: {
                    css: {
                        strong: {
                            fontWeight: theme('fontWeight.bold')
                        }
                    }
                }
            })
        }
    },

    variants: {

    },

    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms')
    ]
};
