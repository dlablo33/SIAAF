
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();


import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { Spanish } from "flatpickr/dist/l10n/es.js";
flatpickr.localize(Spanish);
window.flatpickr = flatpickr;
