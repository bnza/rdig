import Cookies from 'js-cookie';
import getters from './getters'

const SET_USER = 'SET_USER'
const SET_REQ_PENDING = 'SET_REQ_PENDING'
const SET_AUTH_ERROR = 'SET_AUTH_ERROR'
const CLEAR_AUTH_ERROR = 'CLEAR_AUTH_ERROR'

export const state = {
  user: null,
  authError: null,
  requestPending: false
}

export const mutations = {
  [SET_USER] (state, user) {
    state.user = user
  },
  [SET_AUTH_ERROR] (state, error) {
    state.authError = error
  },
  [CLEAR_AUTH_ERROR] (state) {
    state.authError = null
  },
  [SET_REQ_PENDING] (state, flag) {
    state.requestPending = !!flag
  }
}

export const actions = {
  login: async function ({ commit, dispatch, rootState }, credentials) {
    commit(CLEAR_AUTH_ERROR)
    commit(SET_REQ_PENDING, true)
    try {
      const config = {
        method: 'post',
        url: 'login',
        data: credentials
      }
      let response = await dispatch('requests/perform', config, {root: true})
      commit(SET_REQ_PENDING, false)
      commit(SET_USER, response.data)
      return response
    } catch (error) {
      commit(SET_REQ_PENDING, false)
      commit(SET_AUTH_ERROR, error.response)
      throw error
    }
  },
  logout: async function ({ commit, dispatch }) {
    try {
      const config = {
        method: 'post',
        url: 'logout'
      }
      await dispatch('requests/perform', config, {root: true})
      commit(SET_USER, null)
      const token = Cookies.get('xsrf-token')
      if (token) {
        commit('SET_TOKEN', token, {root: true})
        Cookies.remove('xsrf-token')
      }
      return true
    } catch (error) {
      throw error
    }
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
