import Vue from 'vue'
import TableConfig from '../../../api/TableConfig'

const MODULE_NAME = 'tables'
const SET_CONFIG = 'SET_CONFIG'
const SET_IS_REQUEST_PENDING = 'SET_IS_REQUEST_PENDING'
const SET_SORT_CRITERIA = 'SET_SORT_CRITERIA'

export const state = {
  all: {}
}

export const mutations = {
  [SET_CONFIG]: (state, payload) => {
    let tableConfig = new TableConfig(payload.config)
    let component = state.all[payload.key]
    if (component.hasOwnProperty('config')) {
      component.config = tableConfig
    } else {
      Vue.set(component, 'config', tableConfig)
    }
  },
  // TODO validate input
  [SET_IS_REQUEST_PENDING]: (state, payload) => {
    let component = state.all[payload.key]
    Vue.set(component, 'isRequestPending', payload.flag)
  },
  // TODO validate input
  [SET_SORT_CRITERIA]: (state, payload) => {
    let component = state.all[payload.key]
    Vue.set(component, 'sortCriteria', payload.criteria)
  }
}

export const actions = {
  add: function ({dispatch}) {
    return dispatch(
      'components/add',
      {module: MODULE_NAME},
      {root: true}
    )
  },
  setConfig: function ({commit, state, rootGetters}, payload) {
    commit(SET_CONFIG, {
      key: rootGetters['components/key'](payload.uuid),
      config: payload.config
    })
  },
  requestStarted: function ({commit, state, rootGetters}, uuid) {
    commit(SET_IS_REQUEST_PENDING, {
      key: rootGetters['components/key'](uuid),
      flag: true
    })
  },
  requestCompleted: function ({commit, state, rootGetters}, uuid) {
    commit(SET_IS_REQUEST_PENDING, {
      key: rootGetters['components/key'](uuid),
      flag: false
    })
  },
  setSortCriteria: function ({commit, state, rootGetters}, payload) {
    commit(SET_SORT_CRITERIA, {
      key: rootGetters['components/key'](payload.uuid),
      criteria: payload.criteria
    })
  }
}

export const getters = {
  component: (state, getters, rootState, rootGetters) => (uuid) => {
    let key = rootGetters['components/key'](uuid)
    return state.all[key]
  },
  /**
   *
   * @param state
   * @param getters
   * @returns TableConfig
   */
  config: (state, getters) => (uuid) => {
    return getters.component(uuid).config
  },
  tableColumnsNum: (state, getters) => (uuid) => {
    return getters.config(uuid).columnsNumber
  },
  column: (state, getters) => (uuid, columnKey) => {
    return getters.config(uuid).columns[columnKey]
  },
  isColumnVisible: (state, getters) => (uuid, columnKey) => {
    return getters.config(uuid).columns[columnKey]
  },
  columns: (state, getters) => (uuid) => {
    return getters.config(uuid).columns
  },
  field: (state, getters) => (uuid, columnKey) => {
    return getters.column(uuid, columnKey).body.field
  },
  label: (state, getters) => (uuid, columnKey) => {
    return getters.column(uuid, columnKey).label
  },
  tableBodyComponent: (state, getters) => (uuid) => {
    return getters.config(uuid).component
  },
  dataCellComponent: (state, getters) => (uuid, columnKey) => {
    return getters.column(uuid, columnKey).body.component
  },
  tableHeaderComponent: (state, getters) => (uuid) => {
    return getters.config(uuid).header.component
  },
  tableHeaderCellComponent: (state, getters) => (uuid, columnKey) => {
    return getters.column(uuid, columnKey).header.component
  },
  isRequestPending: (state, getters) => (uuid) => {
    return getters.component(uuid).isRequestPending
  },
  sortCriteria: (state, getters) => (uuid) => {
    return getters.component(uuid).sortCriteria
  }
}

export default {
  namespaced: true,
  mutations,
  getters,
  state,
  actions
}
