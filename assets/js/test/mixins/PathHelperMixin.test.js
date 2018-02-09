/* global describe, it, expect, beforeEach */

import { shallow, createLocalVue } from 'vue-test-utils'
import PathHelperMixin from '~/js/src/mixins/PathHelperMixin'
import Vue from 'vue'

describe('PatHelperMixin', () => {
  let wrapper = null

  const initWrapper = function (propsData) {
    const Component = Vue.extend({
      template: '<div></div>',
      mixins: [
        PathHelperMixin
      ],
      props: ['routePrefix', 'tableName', 'id', 'action']
    })

    wrapper = shallow(Component, {
      propsData: propsData
    })
  }

  beforeEach(() => {
    initWrapper({
      routePrefix: 'data',
      tableName: 'site',
      id: 1
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
