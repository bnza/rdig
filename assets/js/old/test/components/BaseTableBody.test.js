/* global describe, test, it, expect, beforeEach, jest */

import Component from '~/js/src/components/BaseTableBody'

import TableConfig from '~/js/src/api/TableConfig'
import BaseTableRow from '~/js/src/components/BaseTableRow'

import {mount} from 'vue-test-utils'

describe('BaseTableBody.vue', () => {
  describe('tableData rendering', () => {
    let tableConfig = new TableConfig({
      columns: {
        id: {},
        name: {}
      }
    })

    let wrapper = mount(
      Component,
      {
        propsData: {
          tableConfig: tableConfig,
          tableData: [
            {id: 0, name: 'name 0'},
            {id: 1, name: 'name 1'}
          ]
        },
        attachToDocument: true
      })

    it('produces 2 <tr> children', () => {
      expect(wrapper.vm.$children.length).toEqual(2)
    })
  })
})
