
let home = require('./components/home.vue').default;
let login = require('./components/login.vue').default;
let register = require('./components/register.vue').default;
let fourzerofour = require('./components/fourzerofour.vue').default;
let dashboard = require('./components/dashboard.vue').default;
const routes = 
    [
        { 
            path: '/', 
            component: home ,
            name: 'home' 
        },
        { 
            path: '/dashboard', 
            component: dashboard ,
            name: 'dashboard' 
        },
        { 
            path: '/login', 
            component: login ,
            name: 'login' 
        },
        { 
            path: '/register', 
            component: register ,
            name: 'register' 
        },
        { 
            path: '*', 
            component: fourzerofour ,
            name: 'fourzerofour' 
        },
       
    ];

export default routes;
