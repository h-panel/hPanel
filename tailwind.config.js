const colors = require('tailwindcss/colors');

const gray = {
    50: 'hsl(216, 33%, 97%)',
    100: 'hsl(214, 15%, 91%)',
    200: 'hsl(210, 16%, 82%)',
    300: 'hsl(211, 13%, 65%)',
    400: '#717F92',
    500: '#717F92',
    600: '#363c44',
    700: '#0069ff',
    800: '#363c44',
    900: '#363c44',
};

const green = {
    50: '#474cd1',
    100: '#474cd1',
    200: '#474cd1',
    300: '#474cd1',
    400: '#474cd1',
    500: '#474cd1',
    600: '#474cd1',
    700: '#474cd1',
    800: '#474cd1',
    900: '#474cd1',
};


module.exports = {
    content: [
        './resources/scripts/**/*.{js,ts,tsx}',
    ],
    theme: {
        extend: {
            fontFamily: {
                header: ['"Inter"', '"Inter"', 'system-ui', 'sans-serif'],
            },
            colors: {
                black: '#131a20',
                // "primary" and "neutral" are deprecated, prefer the use of "blue" and "gray"
                // in new code.
                primary: colors.blue,
                gray: gray,
                neutral: {
                    50: '#ffffff',
                    100: '#ffffff',
                    200: '#C0C9D6',
                    300: '#C0C9D6',
                    400: '#C0C9D6',
                    500: '#C0C9D6',
                    600: '#3A4049',
                    700: '#3A4049',
                    800: '#3A4049',
                    850: '#272B30', // Background colour
                    875: '#363C44', // Sidebar colour
                    900: '#363C44', // Nav/Box colour
                },
                green: {
                    50: '#ffffff',
                    100: '#ffffff',
                    200: '#ffffff',
                    300: '#ffffff',
                    400: '#0069ff',
                    500: '#0069ff',
                    600: '#0069ff',
                    700: '#0069ff',
                    800: '#0069ff',
                    900: '#0069ff',
                },
                cyan: {
                    50: '#ffffff',
                    100: '#ffffff',
                    200: '#ffffff',
                    300: '#ffffff',
                    400: '#474cd1',
                    500: '#474cd1',
                    600: '#474cd1',
                    700: '#474cd1',
                    800: '#474cd1',
                    900: '#474cd1',
                },

            },
            fontSize: {
                '2xs': '0.625rem',
            },
            transitionDuration: {
                250: '250ms',
            },
            borderColor: theme => ({
                default: theme('colors.neutral.400', 'currentColor'),
            }),
        },
    },
    plugins: [
        require('@tailwindcss/line-clamp'),
        require('@tailwindcss/forms')({
            strategy: 'class',
        }),
    ]
};
