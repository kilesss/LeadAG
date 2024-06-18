import {createRouter, createWebHistory} from "vue-router";

import home from '../components/HomePage.vue'
import newCredit from '../components/NewCredit.vue'
import notFound from '../components/NotFound.vue'


const routes = [
    {
        path: '/',
        component: home
    },
    {
        path: '/newCredit',
        component: newCredit
    },
    {
        path: '/:pathMatch(.*)*',
        component: notFound
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
