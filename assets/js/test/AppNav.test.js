/* global describe, test, expect */

import { mount } from 'vue-test-utils'
import Component from '~/js/src/components/AppNavTop.vue'

describe('Component', () => {
  test('is a Vue instance', () => {
    const wrapper = mount(Component)
    expect(wrapper.isVueInstance()).toBeTruthy()
  })
})
