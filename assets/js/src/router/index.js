import Vue from 'vue'
import Router from 'vue-router'
import TheMainHome from '../components/TheMainHome'
import TheLoginModal from '../components/TheLoginModal'

Vue.use(Router)

let router = new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: TheMainHome
    },
    {
      path: '/login',
      name: 'login',
      components: {
        modals: TheLoginModal
      }
    }
  ]
})

export default router
