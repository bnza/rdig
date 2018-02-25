import Vue from 'vue'
import tables from './tables'
import forms from './forms'

const ADD_COMPONENT = 'ADD_COMPONENT'
const REMOVE_COMPONENT = 'REMOVE_COMPONENT'
const INCREMENT = 'INCREMENT'

export const state = {
  uuid: 0,
  all: {}
}

export const mutations = {
  [INCREMENT]: (state) => {
    ++state.uuid
  },
  // TODO validate input
  [ADD_COMPONENT]: (state, payload) => {
    Vue.set(state.all, payload.key, payload.module)
    Vue.set(state[payload.module].all, payload.key, {})
  },
  // TODO validate input
  [REMOVE_COMPONENT]: (state, payload) => {
    Vue.delete(state.all, payload.key)
    Vue.delete(state[payload.module].all, payload.key)
  }
}

export const actions = {
  add: function ({commit, state, getters}, payload) {
    commit(INCREMENT)
    commit(ADD_COMPONENT, {
      module: payload.module,
      key: getters.key()
    })
    return new Promise((resolve) => {
      resolve(state.uuid)
    })
  },
  remove: function ({commit, state, getters}, payload) {
    commit(REMOVE_COMPONENT, {
      module: payload.module,
      key: getters.key(payload.uuid)
    })
  }
}

export const getters = {
  /**
   * Returns last uuid key if not provided
   * @param state
   * @param uuid
   * @returns {string}
   */
  key: (state) => (uuid) => {
    uuid = uuid || state.uuid
    return `k${uuid}`
  },
  module: (state) => (uuid) => {
    return state.all[getters.key(uuid)]
  },
  component: (state, getters) => (uuid) => {
    return state[getters.module(uuid)].all[getters.key(uuid)]
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
  modules: {
    tables: tables,
    forms: forms
  }
}
