module.exports = {
  purge: [
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: 'media', // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
};
// eslint-disable-next-line max-statements
function makeShadow(name, rgb) {
  const obj = {};

  obj[`${name}-xs`] = `0 0 0 1px rgba(${rgb}, 0.05)`;
  obj[`${name}-xs`] = `0 0 0 1px rgba(${rgb}, 0.05)`;
  obj[`${name}-sm`] = `0 1px 2px 0 rgba(${rgb}, 0.05)`;
  obj[`${name}`] = `0 1px 3px 0 rgba(${rgb}, 0.1), 0 1px 2px 0 rgba(${rgb}, 0.06)`;
  obj[`${name}-md`] = `0 4px 6px -1px rgba(${rgb}, 0.1), 0 2px 4px -1px rgba(${rgb}, 0.06)`;
  obj[`${name}-lg`] = `0 10px 15px -3px rgba(${rgb}, 0.1), 0 4px 6px -2px rgba(${rgb}, 0.05)`;
  obj[`${name}-xl`] = `0 20px 25px -5px rgba(${rgb}, 0.1), 0 10px 10px -5px rgba(${rgb}, 0.04)`;
  obj[`${name}-2xl`] = `0 25px 50px -12px rgba(${rgb}, 0.25)`;
  obj[`${name}-inner`] = `inset 0 2px 4px 0 rgba(${rgb}, 0.06)`;

  return obj;
}

module.exports = {
  content: [
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      boxShadow: {
        ...makeShadow('cool-gray', '71, 85, 104'),
        ...makeShadow('gray', '75, 85, 98'),
        ...makeShadow('red', '223, 39, 44'),
        ...makeShadow('orange', '207, 57, 24'),
        ...makeShadow('yellow', '158, 88, 28'),
        ...makeShadow('green', '16, 122, 87'),
        ...makeShadow('teal', '13, 116, 128'),
        ...makeShadow('blue', '29, 100, 236'),
        ...makeShadow('indigo', '87, 81, 230'),
        ...makeShadow('purple', '125, 59, 236'),
        ...makeShadow('pink', '213, 34, 105'),
      } },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
};
