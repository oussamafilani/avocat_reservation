import { createRouter, createWebHashHistory } from 'vue-router'
import Home from '../views/Home.vue'

const routes = [

  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path:'/booking',
    name:'Booking',
    component: () => import(/* webpackChunkName: "brazil" */'../views/Booking.vue'),
    beforeEnter: (to, from, next) => {
      if (sessionStorage.getItem("token")) {
        next();
      } else {
        next({
          name: "Home",
        });
      }
    },
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
