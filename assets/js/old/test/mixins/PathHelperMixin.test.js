/* global describe, it, expect, beforeEach */

import { shallow, createLocalVue } from 'vue-test-utils'
import PathHelperMixin from '~/js/src/mixins/PathHelperMixin'
import Router from 'vue-router'
import Vue from 'vue'
import Vuex from 'vuex'
import { sync } from 'vuex-router-sync'

describe('PatHelperMixin', () => {
  let wrapper = null
  let localVue = null

  const crudRoutes = {
    path: '/:prefix/:table',
    props: true,
    children: [
      {
        path: ':action',
        props: true
      },
      {
        path: ':id(\\d+)/:action',
        props: true
      }
    ]
  }

  const initWrapper = function (propsData) {
    localVue = createLocalVue()
    localVue.use(Vuex)
    localVue.use(Router)

    const router = new Router(crudRoutes)
    let store = new Vuex.Store({})
    sync(store, router)
    const Component = Vue.extend({
      template: '<div></div>',
      mixins: [
        PathHelperMixin
      ]
    })

    wrapper = shallow(Component, {
      localVue,
      router,
      store,
      propsData: propsData
    })
  }

  beforeEach(() => {
    initWrapper({
      route: {
        prefix: 'data',
        table: 'site',
        id: 1
      }
    })
  })

  describe('computed', () => {
    it('"listUrl" returns correct url', () => {
      expect(wrapper.vm.listUrl).toBe('data/site')
    })
    it('"itemUrl" returns correct url', () => {
      expect(wrapper.vm.itemUrl).toBe('data/site/1')
    })
    it('"basePath" returns correct path', () => {
      expect(wrapper.vm.basePath).toBe('/data/site')
    })
    it('"basePath" returns correct path', () => {
      expect(wrapper.vm.baseItemPath).toBe('/data/site/1')
    })
    it('"listPath" returns correct path', () => {
      expect(wrapper.vm.listPath).toBe('/data/site/read')
    })
    it('"itemPath" returns correct path', () => {
      expect(wrapper.vm.itemPath).toBe('/data/site/1/read')
    })
    it('"createPath" returns correct path', () => {
      expect(wrapper.vm.createPath).toBe('/data/site/create')
    })
    it('"deletePath" returns correct path', () => {
      expect(wrapper.vm.deletePath).toBe('/data/site/1/delete')
    })
    it('"updatePath" returns correct path', () => {
      expect(wrapper.vm.updatePath).toBe('/data/site/1/update')
    })
  })

  describe('methods', () => {
    it('"getDeletePath" returns correct path', () => {
      expect(wrapper.vm.getDeletePath(2)).toBe('/data/site/2/delete')
    })
    it('"getItemPath" returns correct path', () => {
      expect(wrapper.vm.getItemPath(2)).toBe('/data/site/2/read')
    })
    it('"getUpdatePath" returns correct path', () => {
      expect(wrapper.vm.getUpdatePath(2)).toBe('/data/site/2/update')
    })
  })
})
