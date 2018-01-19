/* global describe, test, it, expect, beforeEach, jest */

import Component from '~/js/src/components/FormControl'
import {shallow} from 'vue-test-utils'

describe('LoginModalForm.vue', () => {
  describe('props setting', () => {
    describe('icons', () => {
      describe('default value', () => {
        let wrapper = shallow(Component)
        it('main <div> has not has-icons-* class', () => {
          var classes = wrapper.find('div.control').classes()
          expect(classes).not.toContain('has-icons-left')
          expect(classes).not.toContain('has-icons-right')
        })
        it('icon <span> is not rendered', () => {
          var spans = wrapper.findAll('span.icon')
          expect(spans.length).toEqual(0)
        })
      })
      describe('left value', () => {
        let wrapper = shallow(
          Component,
          {
            propsData: {
              icons: {
                left: 'fa-user'
              }
            }
          })
        it('main <div> has has-icons-left class', () => {
          var classes = wrapper.find('div.control').classes()
          expect(classes).toContain('has-icons-left')
        })
        it('left icon <span> is rendered', () => {
          var spans = wrapper.findAll('span.icon')
          expect(spans.length).toEqual(1)
        })
        it('left icon <i> has the given fa-* class', () => {
          expect(wrapper.find('i.fas').classes()).toContain('fa-user')
        })
      })
    })
  })
})
