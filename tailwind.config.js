/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#B2675E',
        secondary: {
          dark: '#644536',
          light: '#6F7C12',
        },
        background: {
          light: '#F2F5EA',
          dark: '#D6DBD2',
        },
      },
    },
  },
  plugins: [],
}
