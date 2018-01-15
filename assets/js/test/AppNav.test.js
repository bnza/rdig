/* global describe, test, expect */

import { mount, createLocalVue } from 'vue-test-utils'
import Component from '~/js/src/components/TheTopAppNav.vue'
import Vuex from 'vuex'

describe('Component', () => {
  test('is a Vue instance', () => {
    const localVue = createLocalVue()
    localVue.use(Vuex)
    const wrapper = mount(Component, {
      mocks: {
        $store: {
          getters: {
            'account/errorMessage': '',
            'account/hasError': false
          },
          state: {
            account: {
              requestPending: false
            }
          }
        }
      },
      localVue})
    expect(wrapper.isVueInstance()).toBeTruthy()
  })
})
