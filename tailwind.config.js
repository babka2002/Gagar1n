/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.antlers.html',
        './resources/**/*.antlers.php',
        './resources/**/*.blade.php',
        './resources/**/*.vue',
        './content/**/*.md',
    ],

    theme: {
        container: {
            center: true,
        },
        fontSize: {
            'sm': "clamp(0.8rem, 0.15vi + 0.77rem, 0.89rem)",
            'base': "clamp(1rem, 0.3vi + 0.93rem, 1.19rem)",
            'md': "clamp(1.25rem, 0.53vi + 1.13rem, 1.58rem)",
            'lg': "clamp(1.56rem, 0.88vi + 1.36rem, 2.11rem)",
            'xl': "clamp(1.95rem, 1.38vi + 1.64rem, 2.81rem)",
            'xxl': "clamp(2.44rem, 2.1vi + 1.97rem, 3.75rem)",
            'xxxl': "clamp(3.05rem, 3.13vi + 2.35rem, 5rem)",
        },
        extend: {
            colors: {
                'main-red': '#980F0F',
                'dark': '#1E1E1E',
                'light': '#FFF8F8',
            },
            zIndex: {
                '9': '9',
            },
            padding: {
                'sectionPadding': 'clamp(1.5rem, -0.1265rem + 7.2289vw, 6rem)',
            },
            borderRadius: {
                'brxl': 'clamp(1rem, 0.5934rem + 1.8072vw, 2.125rem)'
            }
        },
        fontFamily: {
            sans: ['Gothic No60'],
        },
    },

    plugins: [
        require('@tailwindcss/typography'),
        require('tailwindcss-motion'),
    ],
};
