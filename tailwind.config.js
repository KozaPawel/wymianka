/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        light: {
          'text': 'var(--text)',
          'background': 'var(--background)',
          'background-200': 'var(--background-200)',
          'primary': 'var(--primary)',
          'secondary': 'var(--secondary)',
          'accent': 'var(--accent)',
          'hover': 'var(--hover)',
          'hover-gray': 'var(--hover-gray)',
          'danger': 'var(--danger)',
          'focus': 'var(--focus)',
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
