// Import the axios library
import axios from 'axios';

// Make axios available globally
window.axios = axios;

// Set the default 'X-Requested-With' header for all axios requests
// This header is used to identify Ajax requests. Most JavaScript frameworks send this header with value of 'XMLHttpRequest'
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Enable the sending of cross-site credentials in axios
// This means that cookies will be included in requests to different domains
axios.defaults.withCredentials = true;

// Enable the sending of the XSRF token in axios
// This is a security measure to prevent cross-site request forgery attacks
axios.defaults.withXSRFToken = true;
