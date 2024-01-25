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
            component: () => import ('../Pages/Auth/login.vue'),
        },
        {
            path: '/auth/register',
            name: 'register',
            component: () => import ('../Pages/Auth/register.vue'),
        },
        {
            path: '/auth/forgot-password',
            name: 'forgotPassword',
            component: () => import ('../Pages/Auth/forgotPassword.vue'),
        },
        {
            path: '/auth/password-reset',
            name: 'resetPassword',
            component: () => import ('../Pages/Auth/resetPassword.vue'),
        },
        {
            path: '/products',
            name: 'products',
            component: () => import ('../Pages/Product/products.vue'),
        },
        {
            path: '/products-edit',
            name: 'productsEdit',
            component: () => import ('../Pages/Product/productEdit.vue'),
        },
        {
            path: '/products/create',
            name: 'productsCreate',
            component: () => import ('../Pages/Product/productForm.vue'),
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
