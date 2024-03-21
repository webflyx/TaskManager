import {createRouter, createWebHistory} from "vue-router";
import {userStore} from "./store.js";
import App from "./components/App.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: App
        },

        // {
        //     path: '/account',
        //     name: 'account',
        //     component: Account,
        //     meta: {
        //         requiresAuth: true
        //     }
        // },
    ]
})


router.beforeEach( (to, from, next) => {

    async function middleware() {

        await userStore.getUser();

        if (to.matched.some(record => record.meta.requiresAuth)) {

            if (Auth.check()) {
                next();
                return;
            } else {
                router.push('/');
            }

        } else if (to.matched.some(record => record.meta.requiresAdmin)) {

            if (Auth.check() && userStore.userData.role === 'admin') {
                next();
                return;
            } else {
                router.push('/');
            }

        } else {
            next();
        }
    }

    middleware();

});

export default router;
