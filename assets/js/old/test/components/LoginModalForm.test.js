/* global describe, test, it, expect, beforeEach, jest */

import Vue from 'vue'
import Vuex from 'vuex'
import { mount, createLocalVue } from 'vue-test-utils'
import Component from '~/js/src/components/LoginModalForm.vue'

const localVue = createLocalVue()
localVue.use(Vuex)

let wrapper = null

beforeEach(() => {
  const localVue = createLocalVue()
  localVue.use(Vuex)
  wrapper = mount(Component, {
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
})

const fillData1 = function () {
  wrapper.vm.username = 'pippo'
  wrapper.vm.password = 'pluto'
}

describe('LoginModalForm.vue', () => {
  describe('computed property', () => {
    describe('isValid', () => {
      it('is false on empty inputs', () => {
        expect(wrapper.vm.isValid).toBeFalsy()
      })

      it('is false on empty password input', () => {
        wrapper.username = 'pippo'
        expect(wrapper.vm.isValid).toBeFalsy()
      })

      it('is false on empty username input', () => {
        wrapper.password = 'pluto'
        expect(wrapper.vm.isValid).toBeFalsy()
      })

      it('is false on non-empty inputs', () => {
        fillData1()
        expect(wrapper.vm.isValid).toBeTruthy()
      })
    })

    describe('isRequestPending', () => {
      it('is bound to $store.account.requestPending', () => {
        expect(wrapper.vm.isRequestPending).toBeFalsy()
        wrapper.vm.$store.state.account.requestPending = true
        expect(wrapper.vm.isRequestPending).toBeTruthy()
      })
    })

    describe('isButtonDisabled', () => {
      it('is true if isValid is false', () => {
        expect(wrapper.vm.isValid).toBeFalsy()
        expect(wrapper.vm.isButtonDisabled).toBeTruthy()
        /* isRequestPending doesn't matter */
        wrapper.vm.$store.state.account.requestPending = true
        expect(wrapper.vm.isButtonDisabled).toBeTruthy()
      })

      it('is true if isRequestPending is true', () => {
        fillData1()
        wrapper.vm.$store.state.account.requestPending = true
        expect(wrapper.vm.isButtonDisabled).toBeTruthy()
      })

      it('is false if isValid is true and if isRequestPending is false', () => {
        fillData1()
        expect(wrapper.vm.isButtonDisabled).toBeFalsy()
      })
    })
  })

  describe('element', () => {
    describe('submit button', () => {
      it('has disabled attribute if isValid is false', () => {
        expect(wrapper.vm.isValid).toBeFalsy()
        expect(wrapper.vm.isButtonDisabled).toBeTruthy()
      })

      it('has not disabled attribute if isValid is false', () => {
        fillData1()
        expect(wrapper.vm.isButtonDisabled).toBeFalsy()
        return Vue.nextTick().then(function () {
          expect(wrapper.find('.is-link').attributes().disabled).toBeFalsy()
        })
      })

      it('has not disabled attribute if isValid is false', () => {
        fillData1()
        expect(wrapper.vm.isButtonDisabled).toBeFalsy()
        return Vue.nextTick().then(function () {
          expect(wrapper.find('.is-link').attributes().disabled).toBeFalsy()
        })
      })

      test('on click submit button has class is-loaded', () => {
        let stub = jest.fn()
        wrapper.setMethods({ performLogin: stub })

        wrapper.find('.is-link').trigger('click')
        expect(stub).toBeCalled()
      })
    })
  })
})
