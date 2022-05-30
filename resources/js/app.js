require('./bootstrap');

window.Vue = require('vue');


import moment from 'moment';
import 'moment/locale/es';
import { Form, HasError, AlertError } from 'vform';

Vue.component('pagination', require('laravel-vue-pagination'));

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3500
});

const toast1 = swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3500,
    icon:'success'

  });

  const toast2 = swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3500,
    icon:'error'

  });




window.toast = toast;
window.toast1 = toast1;
window.toast2 = toast2;


//cambio de letras
Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('myDate',function(created){
    return moment(created).locale('es').format('LL');
});

Vue.filter('myDate1',function(created){
    return moment(created).locale('es').format('D MMMM YYYY, h:mm a');
});

Vue.filter('myDate2',function(created){
    return moment(created).locale('es').format('LL');
});

Vue.filter('myDate3',function(created){
    return moment(created).locale('es').format('h:mm:ss a');
});

Vue.filter('myDate4',function(created){
    return moment(created).locale('es').startOf('minute').fromNow();
});

Vue.filter('myDate5',function(created){
    return moment(created).locale('es').format("MMMM");
});

window.Fire = new Vue();

Vue.component('spiner', require('./components/spiner.vue').default);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('inicio-component', require('./components/home/InicioComponent.vue').default);

Vue.component('users-component', require('./components/users/UserListComponent.vue').default);
Vue.component('user-show-component', require('./components/users/UserShowComponent.vue').default);


Vue.component('categorias-component', require('./components/categorias/CategoriaComponent.vue').default);

Vue.component('productos-component', require('./components/productos/ProductosComponent.vue').default);

Vue.component('biblioteca-component', require('./components/biblioteca/BibliotecaComponent.vue').default);

Vue.component('inventarios-component', require('./components/inventarios/InventarioComponent.vue').default);

Vue.component('ofertas-component', require('./components/ofertas/OfertaComponent.vue').default);

Vue.component('pedidos-component', require('./components/pedidos/PedidoMenuComponent.vue').default);

Vue.component('cuentas-component', require('./components/cuentas/CuentaComponent.vue').default);

Vue.component('ventas-component', require('./components/ventas/VentaComponent.vue').default);

Vue.component('sugerencias-component', require('./components/sugerencias/SugerenciasComponent.vue').default);

Vue.component('clientes-component', require('./components/clientes/ClientesComponent.vue').default);

Vue.component('pagos-component', require('./components/cuentas/PagosComponent.vue').default);

Vue.component('reportes-component', require('./components/reportes/ReportesComponent.vue').default);

Vue.component('entradamercaderia-component', require('./components/reportes/MercaderiaComponent.vue').default);

Vue.component('bitacora-component', require('./components/bitacoras/BitacoraComponent.vue').default);

Vue.component('kardex-component', require('./components/reportes/KardexComponent.vue').default);


Vue.component('notificaciones-component', require('./components/notificaciones/NotificacionesComponent.vue').default);


Vue.component('pagecliente-component', require('./components/pagecliente/PageclienteComponent.vue').default);
Vue.component('pagelogin-component', require('./components/pagecliente/PageloginComponent.vue').default);
Vue.component('pageacceso-component', require('./components/pagecliente/PageaccesoComponen.vue').default);


const app = new Vue({
    el: '#app',

});

const noti = new Vue({
    el: '#noti',

});

const page = new Vue({
    el: '#page',

});
