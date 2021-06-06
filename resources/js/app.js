require('./bootstrap');
import Vue from  'vue';

//Import Facebook Login
//------

//VueRouter Import

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import routes from './routes';


const router = new VueRouter({
    routes: routes,
    mode : 'history'
})

//----------------------------

//Import navbar

Vue.component('navbar', require('./components/navbar.vue').default)

//--


//Import User Class

import User from './Helpers/User';
window.User = User;
//-----------


//import SweetAlert
import Swal from 'sweetalert2'
window.Swal = Swal;

//Sweet Alert Toast
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

window.Toast = Toast;

//-

//--End of Sweet Alert--------




Vue.config.productionTip =false;

const app = new Vue({
    el: '#app',
    components:{
       
    },  
    router,
});
