require('./bootstrap');
window.Vue = require('vue').default;
import Swal from 'sweetalert2';
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: '#00C851',
  failedColor: 'red',
  height: '2px'
//   thickness: '2px'
})

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('product-component', require('./components/ProductComponent.vue').default);


window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })


window.Swal = Swal;
// window.Toast = Swal;
const app = new Vue({
    el: '#app',
});
