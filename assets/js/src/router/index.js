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
      name: 'data_list_read',
      components: {
        default: TheDataList
      },
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

export const adminTablesRoutes = {
  path: '/:prefix(admin)/:table',
  component: TheMainData,
  props: true,
  children: [
    {
      path: ':action(read)',
      name: 'admin_list_read',
      component: TheDataList,
      props: true
    },
    {
      path: ':id(\\d+)/:action(read)',
      name: 'admin_item_read',
      component: TheDataItem,
      props: true
    },
    {
      path: ':id(\\d+)/:childTable/:action(read)/',
      name: 'admin_child_list_read',
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
    unprivilegedReadRoutes,
    adminTablesRoutes
  ]
})

export default router
