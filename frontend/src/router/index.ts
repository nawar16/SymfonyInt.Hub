import { createRouter, createWebHistory } from 'vue-router'
import ProductView from '../views/ProductView.vue'
import LogView from '../views/LogView.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', name: 'products', component: ProductView },
    { path: '/logs', name: 'logs', component: LogView },
  ],
})

export default router
