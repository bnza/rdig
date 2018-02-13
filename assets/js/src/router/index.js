import Vue from 'vue'
import Router from 'vue-router'
import store from '../store'
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

const crudRoutesParamsFn = function (route) {
  if (route.params.hasOwnProperty('id')) {
    route.params.id = parseInt(route.params.id)
  }
  return route.params
}

const requireAuth = function (to, from, next) {
  if (store.getters['account/isAuthorized'](to)) {
    next()
  } else {
    next('/login')
  }
}

export const crudRoutes = {
  path: '/:prefix(admin|data)/:table',
  component: MainData,
  props: true,
  beforeEnter: requireAuth,
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
    },
    {
      path: ':id(\\d+)/:action(change-password)',
      name: 'change_password',
      component: DataForm,
      props: true
    }
  ]
}

let router = new Router({
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

export default router