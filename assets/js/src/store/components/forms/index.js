import Vue from 'vue'
import TableConfig from '../../../api/FormConfig'

const MODULE_NAME = 'forms'
const SET_CONFIG = 'SET_CONFIG'
const SET_DATA = 'SET_DATA'
const SET_VALUE = 'SET_VALUE'
const SET_IS_REQUEST_PENDING = 'SET_IS_REQUEST_PENDING'

export const state = {
  all: {}
}

export const mutations = {
  [SET_DATA]: (state, payload) => {
    let component = state.all[payload.key]
    Vue.set(component, 'data', payload.data)
  },
  [SET_CONFIG]: (state, payload) => {
    let tableConfig = new TableConfig(payload.config)
    let component = state.all[payload.key]
    Vue.set(component, 'config', tableConfig)
  },
  [SET_VALUE]: (state, payload) => {
    let data = state.all[payload.key].data
    Vue.set(data, payload.fieldKey, payload.value)
  },
  // TODO validate input
  [SET_IS_REQUEST_PENDING]: (state, payload) => {
    let component = state.all[payload.key]
    Vue.set(component, 'isRequestPending', payload.flag)
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
  remove: function ({dispatch}, uuid) {
    return dispatch(
      'components/remove',
      {
        module: MODULE_NAME,
        uuid: uuid
      },
      {root: true}
    )
  },
  setConfig: function ({commit, state, rootGetters}, payload) {
    commit(SET_CONFIG, {
      key: rootGetters['components/key'](payload.uuid),
      config: payload.config
    })
  },
  setData: function ({commit, state, rootGetters}, payload) {
    commit(SET_DATA, {
      key: rootGetters['components/key'](payload.uuid),
      data: payload.data
    })
  },
  setValue: function ({commit, state, rootGetters}, payload) {
    commit(SET_VALUE, {
      key: rootGetters['components/key'](payload.uuid),
      fieldKey: payload.fieldKey,
      value: payload.value

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
  inputToggleStatus ({commit, state, rootGetters}, uuid, fieldKey, status) {
    getters.config(uuid).inputToggleStatus(fieldKey, status)
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
  data: (state, getters) => (uuid) => {
    return getters.component(uuid).data
  },
  fieldData: (state, getters) => (uuid, fieldKey) => {
    let data = getters.data(uuid)
    return data ? data[fieldKey] : null
  },
  fields: (state, getters) => (uuid) => {
    return getters.config(uuid).fields
  },
  field: (state, getters) => (uuid, fieldKey) => {
    return getters.fields(uuid)[fieldKey]
  },
  fieldLabel: (state, getters) => (uuid, fieldKey) => {
    return getters.field(uuid, fieldKey).label
  },
  inputTypeFn: (state, getters) => (uuid, fieldKey) => {
    return getters.config(uuid).getInputType(fieldKey)
  },
  inputColorClassFn: (state, getters) => (uuid, fieldKey) => {
    return getters.config(uuid).getInputColor(fieldKey)
  },
  inputStateClassFn: (state, getters) => (uuid, fieldKey) => {
    return getters.config(uuid).getInputStates(fieldKey)
  },
  inputSizeClassFn: (state, getters) => (uuid, fieldKey) => {
    return getters.config(uuid).getInputSize(fieldKey)
  },
  controlInputComponentFn: (state, getters) => (uuid, fieldKey) => {
    return getters.config(uuid).getInputComponent(fieldKey)
  },
  fieldControlComponentFn: (state, getters) => (uuid, fieldKey) => {
    return getters.config(uuid).getControlComponent(fieldKey)
  },
  fieldComponentFn: (state, getters) => (uuid, fieldKey) => {
    return getters.config(uuid).getFieldComponent(fieldKey)
  }
}

export default {
  namespaced: true,
  mutations,
  getters,
  state,
  actions
}