import { createRouter, createWebHashHistory } from 'vue-router'
import Home from '../views/Home.vue'

// LinkExactActiveClass:'vue-school-active-class',
const routes = [

  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path:'/booking',
    name:'Booking',
    component: () => import(/* webpackChunkName: "brazil" */'../views/Booking.vue')
  },
  {
    path:'/singup',
    name:'Singup',
    component: () => import(/* webpackChunkName: "brazil" */'../views/Singup.vue')
  },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
