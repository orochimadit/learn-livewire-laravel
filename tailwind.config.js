module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  variants: {
    opacity: ['responsive', 'hover', 'focus', 'disabled'],
},
plugins: [
    require('@tailwindcss/ui'),
],
}
