import {createRouter, createWebHistory} from "vue-router";
import {userStore} from "./store.js";
import Login from "./components/Login.vue";
import Auth from "./helpers/auth.js";
import Register from "./components/Register.vue";
import Projects from "./components/Projects.vue";
import Project from "./components/Project.vue";
import Task from "./components/Task.vue";
import App from "./components/App.vue";
import Page404 from "./components/Page404.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            redirect: () => {
                return Auth.check() ? {name: 'projects'} : {name: 'login'}
            }
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/projects',
            name: 'projects',
            component: Projects,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/project/:id',
            name: 'project',
            component: Project,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/tasks',
            name: 'tasks',
            component: Login,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/project/:id/task/:taskId',
            name: 'task',
            component: Task,
            meta: {
                requiresAuth: true
            }
        },

        {
            path: '/:catchAll(.*)',
            name: '404',
            component: Page404
        }
    ]
})


router.beforeEach((to, from, next) => {

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
