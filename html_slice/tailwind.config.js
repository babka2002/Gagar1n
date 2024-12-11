/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./**/*.html", 
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    container: {
      center: true,
    },
    extend: {
          colors: {
            'main-red': '#E23333',
            'dark': '#1E1E1E',
            'light': '#FFF8F8',
          },
          zIndex: {
            '9': '9',
          }
    },
    fontFamily: {
      sans: ['Gothic No60'],
    },
  },
  plugins: [],
}
