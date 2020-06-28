// Polyfills.
if (!global._babelPolyfill) { require('babel-polyfill'); }
import 'whatwg-fetch';

// Global variables.
import { createHooks } from '@wordpress/hooks';
let hooks = createHooks();

export { hooks };