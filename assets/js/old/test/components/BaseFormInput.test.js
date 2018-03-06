/* global describe, test, it, expect, beforeEach, jest */

import Vuex from 'vuex'
import { shallow, createLocalVue } from 'vue-test-utils'
import Component from '~/js/src/components/BaseFormInput'

const localVue = createLocalVue()
localVue.use(Vuex)

describe('BaseTableHeaderCell.vue', () => {
  let getters
  let store
  let wrapper

  let shallowWrapper = function (getters) {
    store = new Vuex.Store({
      modules: {
        components: {
          namespaced: true,
          modules: {
            forms: {
              namespaced: true,
              getters: getters
            }
          }
        }
      }
    })

    wrapper = shallow(
      Component,
      {
        store,
        localVue,
        propsData: {
          uuid: 1,
          fieldKey: 'id'
        }
      }
    )
  }

  describe('template', () => {
    describe('v-bind:class', () => {
      it('renders computed classes', () => {
        getters = {
          inputColorClassFn: () => () => 'is-primary',
          inputSizeClassFn: () => () => 'is-medium',
          inputStateClassFn: () => () => ['is-focused', 'is-loading']
        }
        shallowWrapper(getters)
        const el = wrapper.find('input')
        expect(el.classes()).toContain(getters['inputColorClassFn']()())
        expect(el.classes()).toContain(getters['inputSizeClassFn']()())
        let stateClasses = getters['inputStateClassFn']()()
        for (let i in stateClasses) {
          expect(el.classes()).toContain(stateClasses[i])
        }
      })
    })
  })
})
