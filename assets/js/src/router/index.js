import Vue from 'vue'
import Router from 'vue-router'
import MainHome from '../components/MainHome'
import MenuLeft from '../components/MenuLeft'
import MainData from '../components/MainData'
import LoginModal from '../components/LoginModal'

const DataForm = () => import(
  /* webpackChunkName: "DataForm" */
  '../components/DataForm'
  )

const DataList = () => import(
  /* webpackChunkName: "DataList" */
  '../components/DataList'
  )

const DataFormDelete = () => import(
  /* webpackChunkName: "DataFormDelete" */
  '../components/DataFormDeleteModal'
  )

Vue.use(Router)

export const crudRoutes = {
  path: '/:routePrefix(admin|data)/:tableName',
  component: MainData,
  props: true,
  children: [
    {
      path: ':action(create)',
      component: DataForm,
      props: true
    },
    {
      path: ':action(read)',
      name: 'data_list',
      component: DataList,
      props: true
    },
    {
      path: ':id(\\d+)/:action(read|update|delete)',
      name: 'data_element',
      component: DataForm,
      props: true
    }
  ]
}

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
    crudRoutes
  ]
})
