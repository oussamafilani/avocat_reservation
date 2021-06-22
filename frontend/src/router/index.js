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
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  },
  {
    path:'/brazil',
    name:'brazil',
    component: () => import(/* webpackChunkName: "brazil" */'../views/Brazil.vue')
  },
  {
    path:'/hawaii',
    name:'hawaii',
    component: () => import(/* webpackChunkName: "hawaii" */'../views/Hawaii.vue')
  },
  {
    path:'/jamaica',
    name:'jamaica',
    component: () => import(/* webpackChunkName: "jamaica" */'../views/Jamaica.vue')

  },
  {
    path:'/panama',
    name:'panama',
    component: () => import(/* webpackChunkName: "panama" */'../views/Panama.vue')
  },
  {
    path:'/details/:id',
    name:'DestinationDetails',
    component : ()=> import(/* webpackChunkName: "DestinationDetails" */'../views/DestinationDetails')
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
