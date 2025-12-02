/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./resources/views/**/*.blade.php",
    "./resources/views/components/**/*.blade.php",
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
        coffee: '#644536',
        terracotta: '#B2675E',
        ivory: '#F2F5EA',
        dust: '#D6DBD2',
        olive: '#6F7C12',
      },
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
        serif: ['Playfair Display', 'serif'],
      },
    },
  },
  safelist: [
    'bg-coffee',
    'bg-terracotta',
    'bg-ivory',
    'bg-dust',
    'bg-olive',
    'text-coffee',
    'text-terracotta',
    'text-ivory',
    'text-dust',
    'text-olive',
    'border-coffee',
    'border-terracotta',
    'border-ivory',
    'border-dust',
    'border-olive',
  ],
  plugins: [],
}
