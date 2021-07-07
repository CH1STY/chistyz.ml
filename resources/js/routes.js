
let home = require('./components/home.vue').default;
let login = require('./components/login.vue').default;
let logout = require('./components/logout.vue').default;
let register = require('./components/register.vue').default;
let fourzerofour = require('./components/fourzerofour.vue').default;
let dashboard = require('./components/dashboard.vue').default;
let todo = require('./components/todo.vue').default;
let addCat = require('./components/Category/categoryAdd').default;
let viewCat = require('./components/Category/categoryView').default;
let editCat = require('./components/Category/categoryEdit').default;
let forget_pass = require('./components/ForgetPass/forget-pass').default;
let reset_pass = require('./components/ForgetPass/reset-pass').default;
let addProduct = require('./components/Product/productAdd').default;
let viewProduct = require('./components/Product/productView').default;
let productDetails = require('./components/Product/productDetails').default;
let editProduct = require('./components/Product/productEdit').default;
let editProfile = require('./components/User/profileEdit').default;
let searchProduct = require('./components/Product/productSearch').default;
let cart = require('./components/Cart/cart').default;
const routes = 
    [
        { 
            path: '/', 
            component: home ,
            name: 'home' 
        },
        {
            path:'/product/search',
            component: searchProduct,
            name: 'productSearch',
            props: route=>({query: route.query.q})

        },
        { 
            path: '/dashboard', 
            component: dashboard ,
            name: 'dashboard' 
        },
        { 
            path: '/user/edit', 
            component: editProfile ,
            name: 'editProfile' 
        },
        {
            path: '/todo',
            component: todo,
            name: 'todo'
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
            path : '/admin/addProduct',
            component : addProduct,
            name : 'addProduct',
        },
        {
            path : '/viewProduct',
            component : viewProduct,
            name : 'viewProduct',
        },
        {
            path : '/details/:productId',
            component : productDetails,
            name : 'details',
        },
        {
            path : '/cart',
            component : cart,
            name : 'cart',
        },
        {
            path : '/admin/editProduct/:productId',
            component : editProduct,
            name : 'editProduct',
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
            path : '/forget-password',
            component : forget_pass,
            name : 'forget_pass',

        },
        {
            path : '/reset-password/:token',
            component : reset_pass,
            name : 'reset_pass',

        },
        { 
            path: '*', 
            component: fourzerofour ,
            name: 'fourzerofour' 
        },
       
    ];

export default routes;
