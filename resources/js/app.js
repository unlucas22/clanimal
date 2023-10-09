import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';
import 'flowbite';
import ApexCharts from 'apexcharts'

window.ApexCharts = ApexCharts;

window.Alpine = Alpine;
window.Swal = Swal;

Alpine.plugin([focus, collapse]);

Alpine.start();
