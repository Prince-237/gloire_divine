/**
 * ⚠️ Fichier à utiliser UNIQUEMENT si `npm list tailwindcss` (dans ton
 * projet) affiche une version 3.x. Si c'est déjà une version 4.x, IGNORE
 * ce fichier — resources/css/app.css suffit (les tokens sont déjà dedans
 * via @theme, la syntaxe Tailwind v4).
 *
 * Si tu es en v3, remplace ton tailwind.config.js par celui-ci, ET
 * remplace le contenu de resources/css/app.css par les 3 directives
 * classiques :
 *   @tailwind base;
 *   @tailwind components;
 *   @tailwind utilities;
 * (en gardant l'import Google Fonts en première ligne).
 */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        primary: { DEFAULT: '#1B6B3D', light: '#2B8A52', dark: '#124D2B' },
        accent: { DEFAULT: '#7DB13C', light: '#A6CC72' },
        ink: { DEFAULT: '#1F2A24', soft: '#5B6B60' },
        bg: '#FFFFFF',
        surface: '#FFFFFF',
        tint: '#EEF5E9',
        border: '#DCE8D3',
      },
      fontFamily: {
        display: ['Lora', 'serif'],
        body: ['Inter', 'sans-serif'],
      },
    },
  },
  plugins: [],
};
