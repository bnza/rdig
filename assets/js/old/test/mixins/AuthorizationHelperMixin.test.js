/* global describe, it, expect, beforeEach */

import { shallow, createLocalVue } from 'vue-test-utils'
import account from '~/js/src/store/account'
import AuthorizationHelperMixin from '~/js/src/mixins/AuthorizationHelperMixin'
import Vue from 'vue'
import Vuex from 'vuex'
import Router from 'vue-router'

describe('AuthorizationHelperMixin', () => {
  let localVue = null
  let wrapper = null

  const testPaths = function (paths) {
    for (let i = 0; i < paths.length; i++) {
      let path = paths[i]
      let result = path[1] ? 'succeeded' : 'fails'
      it(`${result} with "${path[0]}"`, () => {
        expect(wrapper.vm.authorize(path[0])).toBe(path[1])
      })
    }
  }

  const loginAdmin = function () {
    wrapper.vm.$store.commit('account/SET_USER', {username: 'admin', roles: ['ROLE_ADMIN']})
  }

  const loginUser = function () {
    wrapper.vm.$store.commit('account/SET_USER', {username: 'pippo', roles: ['ROLE_USER']})
  }

  const initWrapper = function () {
    localVue = createLocalVue()
    localVue.use(Vuex)
    localVue.use(Router)

    const store = new Vuex.Store(
      {
        modules: {
          account: account
        }
      }
    )
    const router = new Router({
      routes: [
        {
          path: '/:route(admin|data)/:table',
          children: [
            {
              path: ':action(create|read)'
            },
            {
              path: ':id(\\d+)/:action(read|update|delete)'
            }
          ]
        }
      ]
    })
    let Component = new Vue({
      template: '<div></div>'
    })

    wrapper = shallow(Component, {
      localVue,
      router,
      store,
      mixins: [
        AuthorizationHelperMixin
      ]
    })
  }

  describe('method', () => {
    beforeEach(() => {
      initWrapper()
    })

    describe('"authorize" on unauthenticated user', () => {
      let paths = [
        ['/invalid/path', false],
        ['/data/site/read', true],
        ['/data/site/1/read', true],
        ['/data/pottery/read', true],
        ['/data/pottery/1/read', true],
        ['/data/pottery/create', false],
        ['/data/site/create', false],
        ['/admin/user/read', false],
        ['/admin/user/1/read', false]
      ]
      testPaths(paths)
    })

    describe('"authorize" on ROLE_ADMIN user', () => {
      beforeEach(() => {
        loginAdmin()
      })
      let paths = [
        ['/invalid/path', false],
        ['/data/site/read', true],
        ['/data/site/1/read', true],
        ['/data/pottery/read', true],
        ['/data/pottery/1/read', true],
        ['/data/pottery/create', true],
        ['/data/site/create', true],
        ['/admin/user/read', true],
        ['/admin/user/1/read', true]
      ]
      testPaths(paths)
    })

    describe('"authorize" on ROLE_USER user', () => {
      beforeEach(() => {
        loginUser()
      })
      let paths = [
        ['/invalid/path', false],
        ['/data/site/read', true],
        ['/data/site/1/read', true],
        ['/data/site/create', false],
        ['/data/pottery/read', true],
        ['/data/pottery/1/read', true],
        ['/data/pottery/create', true],
        ['/admin/user/read', false],
        ['/admin/user/1/read', false]
      ]
      testPaths(paths)
    })
  })
})
