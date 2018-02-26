import Vue from 'vue'
import Router from 'vue-router'
import TheMainData from '../components/TheMainData'
import TheMainHome from '../components/TheMainHome'
import TheLoginModal from '../components/TheLoginModal'
import TheDataList from '../components/TheDataList'
import TheDataItem from '../components/TheDataItem'

Vue.use(Router)

export const unprivilegedReadRoutes = {
  path: '/:prefix(data)/:table',
  component: TheMainData,
  props: true,
  children: [
    {
      path: ':action(read)',
      name: 'data_table_read',
      component: TheDataList,
      props: true
    },
    {
      path: ':id(\\d+)/:action(read)',
      name: 'data_item_read',
      component: TheDataItem,
      props: true
    }
  ]
}

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
        default: TheMainHome,
        modals: TheLoginModal
      }
    },
    unprivilegedReadRoutes
  ]
})

export default router
