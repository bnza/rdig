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
  login: async function ({ commit, dispatch }, credentials) {
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
      let response = await dispatch('requests/perform', config, {root: true})
      commit(SET_USER, null)
      return true
    } catch (error) {
      throw error
    }
  }
}

export const getters = {
  isAuthenticated: state => {
    return state.user instanceof Object && state.user.hasOwnProperty('username')
  },
  errorMessage: state => {
    return state.authError ? state.authError.data : ''
  },
  hasError: state => {
    return !!state.authError
  },
  username: (state, getters) => {
    return getters.isAuthenticated ? state.user.username : ''
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
