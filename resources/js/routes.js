
let home = require('./components/home.vue').default;
let login = require('./components/login.vue').default;
let logout = require('./components/logout.vue').default;
let register = require('./components/register.vue').default;
let fourzerofour = require('./components/fourzerofour.vue').default;
let dashboard = require('./components/dashboard.vue').default;
let addCat = require('./components/Category/categoryAdd').default;
let viewCat = require('./components/Category/categoryView').default;
let editCat = require('./components/Category/categoryEdit').default;
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
            path : '/logout',
            component : logout,
            name : 'logout',
        },
        {
            path : '/admin/addCat',
            component : addCat,
            name : 'addCat',
        },
        {
            path : '/admin/viewCat',
            component : viewCat,
            name : 'viewCat',
        },
        {
            path : '/admin/editCat/:catId',
            component: editCat,
            name : 'editCat',
        },
        { 
            path: '*', 
            component: fourzerofour ,
            name: 'fourzerofour' 
        },
       
    ];

export default routes;
