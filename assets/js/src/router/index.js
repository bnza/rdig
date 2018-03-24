import Vue from 'vue'
import Router from 'vue-router'
import TheMainData from '../components/TheMainData'
import TheMainHome from '../components/TheMainHome'
import TheLoginModal from '../components/TheLoginModal'
import TheLogoutModal from '../components/TheLogoutModal'
import TheDataList from '../components/TheDataList'
import TheDataItem from '../components/TheDataItem'
import store from '../store'
import {authMxAuthorize} from '../mixins/AuthMx'
import {uuidMxSet} from '../mixins/UuidMx'

Vue.use(Router)

const authorizeRoute = function (to, from, next) {
  if (to.params.prefix === 'data' && to.params.id) {
    const config = {
      method: 'get',
      url: `data/${to.params.table}/${to.params.id}/site`
    }
    store.dispatch('requests/perform', config).then(
      (response) => {
        if (authMxAuthorize(to, response.data.siteId, store, router)) {
          next()
        } else {
          next('/login')
        }
      }
    )
  } else {
    if (authMxAuthorize(to, undefined, store, router)) {
      next()
    } else {
      next('/login')
    }
  }
}

const TheCreateModal =() => import(
  /* webpackChunkName: "TheAddModal" */
  '../components/TheAddModal'
  )
const TheDeleteModal = () => import(
  /* webpackChunkName: "TheDeleteModal" */
  '../components/TheDeleteModal'
  )
const TheSearchModal = () => import(
  /* webpackChunkName: "TheSearchModal" */
  '../components/TheSearchModal'
  )
const TheUpdateModal = () => import(
  /* webpackChunkName: "TheEditModal" */
  '../components/TheEditModal'
  )

export const dataRoutes = {
  path: '/:prefix(data|admin)/:table',
  component: TheMainData,
  props: true,
  children: [
    {
      path: ':action(read)',
      name: 'data_list_read',
      component: TheDataList,
      beforeEnter: authorizeRoute,
      props: true
    },
    {
      path: ':action(create)',
      name: 'data_list_create',
      components: {
        default: TheDataList,
        modal: TheCreateModal
      },
      beforeEnter: authorizeRoute,
      props: true
    },
    {
      path: ':action(search)',
      name: 'data_list_search',
      components: {
        default: TheDataList,
        modal: TheSearchModal
      },
      beforeEnter: authorizeRoute,
      props: true
    },
    {
      path: ':id(\\d+)/:action(read)',
      name: 'data_item_read',
      component: TheDataItem,
      beforeEnter: authorizeRoute,
      props: true
    },
    {
      path: ':id(\\d+)/:action(delete)',
      name: 'data_item_delete',
      components: {
        default: TheDataList,
        modal: TheDeleteModal
      },
      beforeEnter: authorizeRoute,
      props: true
    },
    {
      path: ':id(\\d+)/:action(update)',
      name: 'data_item_update',
      components: {
        default: TheDataList,
        modal: TheUpdateModal
      },
      beforeEnter: authorizeRoute,
      props: true
    },
    {
      path: ':id(\\d+)/:childTable/:action(read)',
      name: 'data_child_list_read',
      component: TheDataItem,
      beforeEnter: authorizeRoute,
      props: true
    },
    {
      path: ':id(\\d+)/:childTable/:action(search)',
      name: 'data_child_list_search',
      components: {
        default: TheDataItem,
        modal: TheSearchModal
      },
      beforeEnter: authorizeRoute,
      props: true
    },
    {
      path: ':id(\\d+)/:childTable/:action(create)',
      name: 'data_child_list_create',
      components: {
        default: TheDataItem,
        modal: TheCreateModal
      },
      beforeEnter: authorizeRoute,
      props: true
    },
    {
      path: ':id(\\d+)/:childTable/:childId(\\d+)/:action(read)',
      name: 'data_child_item_read',
      redirect: '/:prefix/:childTable/:childId/read'
    },
    {
      path: ':id(\\d+)/:childTable/:childId(\\d+)/:action(delete)',
      name: 'data_child_item_delete',
      components: {
        default: TheDataItem,
        modal: TheDeleteModal
      },
      beforeEnter: authorizeRoute,
      props: true
    },
    {
      path: ':id(\\d+)/:childTable/:childId(\\d+)/:action(update)',
      name: 'data_child_item_update',
      components: {
        default: TheDataItem,
        modal: TheUpdateModal
      },
      beforeEnter: authorizeRoute,
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
    {
      path: '/logout',
      name: 'logout',
      components: {
        default: TheMainHome,
        modals: TheLogoutModal
      }
    },
    dataRoutes
  ]
})

router.beforeEach((to, from, next) => {
  console.log(to)
  if (to.matched.length === 0) {
    uuidMxSet(store, 'text', 'Requested resource does not exist', 'the-snack-bar')
    uuidMxSet(store, 'color', 'warning', 'the-snack-bar')
    uuidMxSet(store, 'active', true, 'the-snack-bar')
    next(from)
  }
  next()
})
export default router
