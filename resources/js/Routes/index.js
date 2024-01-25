import {createRouter, createWebHistory} from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: () => import ('../Pages/dashboard.vue'),
        },
        {
            path: '/auth/login',
            name: 'login',
            component: () => import ('../Pages/login.vue'),
        },
        {
            path: '/auth/register',
            name: 'register',
            component: () => import ('../Pages/register.vue'),
        },
        {
            path: '/auth/forgot-password',
            name: 'forgotPassword',
            component: () => import ('../Pages/forgotPassword.vue'),
        },
        {
            path: '/auth/password-reset',
            name: 'resetPassword',
            component: () => import ('../Pages/resetPassword.vue'),
        },
        {
            path: '/products',
            name: 'products',
            component: () => import ('../Pages/products.vue'),
        },
        {
            path: '/products-edit',
            name: 'productsEdit',
            component: () => import ('../Pages/ProductEdit.vue'),
        },
        {
            path: '/products/create',
            name: 'productsCreate',
            component: () => import ('../Pages/ProductForm.vue'),
        },
        {
            path: '/:pathMatch(.*)*',
            component: () => import ('../Pages/error404.vue'),
        }

    ]

})

const isLogined = () => {
    return localStorage.getItem('token');
}

router.beforeEach(async (to, from, next) => {

    if ((to.name === 'register' || to.name === 'forgotPassword'|| to.name === 'resetPassword') && !isLogined()) {
        next();
    } else if (to.name !== 'login'   && !isLogined()) {
        next('/auth/login');
    }
    else if ((to.name === 'login' || to.name === 'register') && isLogined()) {
        next('/');
    } else {
        next();
    }
})

export default router;
