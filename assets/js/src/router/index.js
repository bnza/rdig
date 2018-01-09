import Vue from 'vue'
import Router from 'vue-router'
import HomeMain from '../components/MainHome'
import MenuLeft from '../components/MenuLeft'
import LoginModal from '../components/LoginModal'

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
    },
    {
      path: '/login',
      name: 'login',
      components: {
        modal: LoginModal
      }
    }
  ]
})
