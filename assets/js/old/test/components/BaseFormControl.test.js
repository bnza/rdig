/* global describe, test, it, expect, beforeEach, jest */

import Vuex from 'vuex'
import { mount, shallow, createLocalVue } from 'vue-test-utils'
import Component from '~/js/src/components/BaseFormControl'

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
          controlInputComponentFn: () => () => 'BaseFormInput'
        }
        shallowWrapper(getters)
        const el = wrapper.find('div')
        expect(el.classes()).toContain('control')
      })
    })
  })
})
