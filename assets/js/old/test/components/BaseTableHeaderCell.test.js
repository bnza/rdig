/* global describe, test, it, expect, beforeEach, jest */

import Vuex from 'vuex'
import { shallow, createLocalVue } from 'vue-test-utils'
import BaseTableHeaderCell from '~/js/src/components/BaseTableHeaderCell'

const localVue = createLocalVue()
localVue.use(Vuex)

describe('BaseTableHeaderCell.vue', () => {
  let getters
  let store
  let wrapper

  beforeEach(() => {
    getters = {
      field: () => (uuid, columnKey) => 'id_field',
      label: () => (uuid, columnKey) => 'id_label'
    }
    store = new Vuex.Store({
      modules: {
        components: {
          namespaced: true,
          modules: {
            tables: {
              namespaced: true,
              getters: getters
            }
          }
        }
      }
    })
    wrapper = shallow(
      BaseTableHeaderCell,
      {
        store,
        localVue,
        propsData: {
          uuid: 1,
          columnKey: 'id'
        }
      }
    )
  })

  it('Renders \'components/tables/label\' <th> tag', () => {
    const p = wrapper.find('th')
    expect(p.text()).toEqual(getters['label']()())
  })
})
