/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Datepicker from "vuejs-datepicker";
import VueSweetalert2 from "vue-sweetalert2";

// If you don't need the styles, do not connect
import "sweetalert2/dist/sweetalert2.min.css";

Vue.use(VueSweetalert2);
window.Vuetify = require('vuetify');
Vue.use(Vuetify);
// Vue.use(require('vue-moment'));
import 'vuetify/dist/vuetify.min.css';

Vue.component("datepicker", Datepicker);
Vue.component('producto-component', require('./components/ProductoComponent.vue').default);
Vue.component('marca-component', require('./components/ConcentracionComponent.vue').default);
Vue.component('medicamento-component', require('./components/MedicamentosComponent.vue').default);
Vue.component('presentacion-component', require('./components/PresentacionComponent.vue').default);
Vue.component('laboratorio-component', require('./components/LaboratorioComponent.vue').default);
Vue.component('user-component', require('./components/UserComponent.vue').default);
Vue.component('cliente-component', require('./components/ClienteComponent.vue').default);
Vue.component('proveedor-component', require('./components/ProveedorComponent.vue').default);
Vue.component('ingresos-component', require('./components/IngresoComponent.vue').default);
Vue.component('venta-component', require('./components/VentaComponent.vue').default);
Vue.component('reporte-c', require('./components/ReportIngresoComponent.vue').default);
Vue.component('reporte-v', require('./components/ReportVentaComponent.vue').default);
Vue.component('reporte-vendedor', require('./components/ReporteVendedor.vue').default);
Vue.component('escritorio-v', require('./components/Dashboard.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    vuetify: new Vuetify({

    }),
    el: "#app",
    data: {
        menu: 0,
            ruta: "http://innova.deliverygasperu.com/public/"
        // ruta: '/innova_dent/public'
            // ruta: "http://127.0.0.1:8000"

    }
});
// export default new Vuetify({

// });
