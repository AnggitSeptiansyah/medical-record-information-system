import './bootstrap';

import Alpine from 'alpinejs';
// import Choices from 'choices.js';
import { initializeCharts } from './dashboard-charts';

window.Alpine = Alpine;
window.initializeCharts = initializeCharts;
// window.Choices = Choices;

Alpine.start();
