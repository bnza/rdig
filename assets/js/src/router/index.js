import Vue from 'vue'
import Router from 'vue-router'
import MainHome from '../components/MainHome'
import MenuLeft from '../components/MenuLeft'
import MainData from '../components/MainData'
import LoginModal from '../components/LoginModal'
import DataForm from '../components/DataForm'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: MainHome
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
    },
    { path: '/data/:tablename',
      component: MainData,
      props: true,
      children: [
        {
          path: ':action(create)',
          component: DataForm,
          props: true
        },
        {
          path: ':id(\\d+)/:action(read|update|delete)',
          component: DataForm,
          props: true
        }
      ]
    }
  ]
})
