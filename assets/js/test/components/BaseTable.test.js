/* global describe, test, it, expect, beforeEach, jest */

import Component from '~/js/src/components/BaseTable'
import TableConfig from '~/js/src/api/TableConfig'
import {mount} from 'vue-test-utils'

describe('BaseTable.vue', () => {
  describe('props setting', () => {
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
          tableConfig: tableConfig
        }
      })

    describe('"tableConfig"', () => {
      it('component receives "tableConfig" prop', () => {
        expect(wrapper.vm.tableConfig).toEqual(tableConfig)
      })
      it('children component "body" receives "tableConfig" prop', () => {
        expect(wrapper.vm.$refs.body.tableConfig).toEqual(tableConfig)
      })
    })
  })
})
