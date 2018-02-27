import Vue from 'vue'

const ADD_COMPONENT = 'ADD_COMPONENT'
const REMOVE_COMPONENT = 'REMOVE_COMPONENT'
const INCREMENT = 'INCREMENT'
const SET_VALUE = 'SET_VALUE'

export const state = {
  uuid: 0,
  all: {}
}

export const mutations = {
  [INCREMENT]: (state) => {
    ++state.uuid
  },
  // TODO validate input
  [ADD_COMPONENT]: (state, uuid) => {
    if (!state.all.hasOwnProperty(uuid)) {
      Vue.set(state.all, uuid, {})
    }
  },
  // TODO validate input
  [REMOVE_COMPONENT]: (state, uuid) => {
    Vue.delete(state.all, uuid)
  },
  // TODO validate input
  [SET_VALUE]: (state, payload) => {
    Vue.set(state.all[payload.uuid], payload.key, payload.value)
  }
}

export const actions = {
  add: function ({commit, state}, uuid) {
    if (!uuid.startsWith('the-')) {
      commit(INCREMENT)
      uuid = `${uuid}-${state.uuid}`
    }
    commit(ADD_COMPONENT, uuid)
    return new Promise((resolve) => {
      resolve(uuid)
    })
  },
  remove: function ({commit}, uuid) {
    commit(REMOVE_COMPONENT, uuid)
  },
  set: function ({commit, dispatch, state}, payload) {
    if (!state.all.hasOwnProperty(payload.uuid)) {
      return new Promise(
        (resolve) => {
          dispatch('add', payload.uuid).then(
            (uuid) => {
              payload.uuid = uuid
              dispatch('set', payload).then(
                (uuid) => {
                  resolve(uuid)
                }
              )
            }
          )
        }
      )
    } else {
      commit(SET_VALUE, payload)
      return new Promise((resolve) => {
        resolve(payload.uuid)
      })
    }
  }
}

export const getters = {
  value: (state) => (uuid, key) => {
    let component = state.all[uuid]
    return component ? component[key] : undefined
  }
}

export default {
  strict: true,
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
