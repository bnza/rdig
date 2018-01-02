import Vue from 'vue'
import Router from 'vue-router'
import TestLeft from '../components/TestLeft'
import MenuLeft from '../components/MenuLeft'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: TestLeft
    },
    {
      path: '/cart',
      name: 'cart',
      component: MenuLeft
    },
  ]
})