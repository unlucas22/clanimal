import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';
import 'flowbite';
import ApexCharts from 'apexcharts'
// import Calendar from "color-calendar";
// import "color-calendar/dist/css/theme-basic.css";
import Datepicker from 'flowbite-datepicker/Datepicker';

window.ApexCharts = ApexCharts;

window.Alpine = Alpine;
window.Swal = Swal;

window.Datepicker = Datepicker;
// window.Calendar = Calendar;

Alpine.plugin([focus, collapse]);

Alpine.start();
