import Vue from 'vue'
import Router from 'vue-router'
import HomeMain from '../components/HomeMain'
import MenuLeft from '../components/MenuLeft'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeMain
    },
    {
      path: '/cart',
      name: 'cart',
      component: MenuLeft
    }
  ]
})
