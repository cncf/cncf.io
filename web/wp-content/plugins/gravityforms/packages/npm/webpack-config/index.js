const { NODE_ENV } = process.env;
const packageJson = require('./package.json');

console.info(`@gravityforms/webpack-config v${packageJson.version}`);

module.exports = require( `./src/${ NODE_ENV }` );
