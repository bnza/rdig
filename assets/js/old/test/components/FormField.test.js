/* global describe, test, it, expect, beforeEach, jest */

import Component from '~/js/src/components/FormField'
import {shallow} from 'vue-test-utils'

describe('LoginModalForm.vue', () => {
  describe('props setting', () => {
    describe('label', () => {
      it('set <label> text', () => {
        let wrapper = shallow(
          Component,
          {
            propsData: {
              label: 'Username'
            }
          })
        expect(wrapper.find('label').text()).toEqual('Username')
      })
    })

    describe('helpMessage', () => {
      it('empty <p> text if no prop', () => {
        let wrapper = shallow(
          Component,
          {
            propsData: {
              label: 'Username'
            }
          })
        expect(wrapper.find('p.help').text()).toBeFalsy()
      })

      it('set <p> text', () => {
        let wrapper = shallow(
          Component,
          {
            propsData: {
              label: 'Username',
              helpMessage: {
                message: 'Help message'
              }
            }
          })
        expect(wrapper.find('p.help').text()).toEqual('Help message')
      })

      it('empty <p> CSS color class', () => {
        let wrapper = shallow(
          Component,
          {
            propsData: {
              label: 'Username',
              helpMessage: {
                message: 'Help message',
                className: 'is-primary'
              }
            }
          })
        expect(wrapper.find('p.help').classes()).toContain('is-primary')
      })
    })
  })
})
