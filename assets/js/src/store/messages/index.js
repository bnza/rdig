import Vue from 'vue'

const REGISTER_MESSAGE = 'REGISTER_MESSAGE'
const UNREGISTER_MESSAGE = 'UNREGISTER_MESSAGE'

export const state = {
  all: {},
  index: -1
}

export const mutations = {
  [REGISTER_MESSAGE] (state, payload) {
    let key = `k${++state.index}`
    let message = {
      body: payload.body,
      className: payload.className
    }
    Vue.set(state.all, key, message)
  },
  [UNREGISTER_MESSAGE] (state, key) {
    if (state.all.hasOwnProperty(key)) {
      Vue.delete(state.all, key)
    }
  }
}

export const actions = {
  addMessage: function ({commit, getters}, payload) {
    commit({
      type: REGISTER_MESSAGE,
      body: payload.body,
      className: payload.className
    })
    let key = getters.currentKey
    setTimeout(function () {
      commit(UNREGISTER_MESSAGE, key)
    }, 5000)
  },
  handleResponseError: function ({dispatch}, response) {
    if (response.data && response.data.error) {
      let error = response.data.error
      let message = 'Application error'
      if (error.hasOwnProperty('violations')) {
        message = 'Data validation error'
      } else if (error.hasOwnProperty('exception')) {
        message = error.exception
      }
      dispatch({
        type: 'addMessage',
        body: message,
        className: 'is-danger'
      })
    }
  }
}

export const getters = {
  currentKey: state => {
    return `k${state.index}`
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
