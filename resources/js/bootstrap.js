import axios from 'axios';

// Make the axios instance globally available via the window object.
window.axios = axios;

// Set the default headers for all axios requests to include 'X-Requested-With' header with the value 'XMLHttpRequest'.
// This is commonly used to identify Ajax requests and can be useful for handling them differently on the server.
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Configure axios to include credentials (such as cookies, authorization headers, or TLS client certificates) in requests by default.
// This is useful for cross-site requests that require authentication.
axios.defaults.withCredentials = true;

// Enable the inclusion of XSRF (Cross-Site Request Forgery) tokens in axios requests by default.
// This helps protect against CSRF attacks by ensuring that the token is sent with requests.
axios.defaults.withXSRFToken = true;
