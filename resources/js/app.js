import './bootstrap';
import Swal from 'sweetalert2';
import AOS from 'aos' AOS.init();
import { Chart, registerables } from 'chart.js';
import L from 'leaflet';
import axios from 'axios';
window.axios = axios;

Chart.register(...registerables);