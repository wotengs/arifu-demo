/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './resources/views/Filament/**/*.blade.php',
        './resources/views/components/**/*.blade.php',
        './resources/views/pages/**/*.blade.php',
        './resources/views/forms/**/*.blade.php',
        './resources/views/widgets/**/*.blade.php',
        
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

