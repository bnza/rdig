import axios from 'axios'

const NEW_REQUEST = 'NEW_REQUEST'
const SET_REQUEST_FULFILLED = 'SET_REQUEST_FULFILLED'

export const state = {
  all: [],
  pending: []
}

export const mutations = {
  [NEW_REQUEST] (state, request) {
    state.all.push(request)
    const index = state.all.length - 1
    state.pending.push(index)
    return index
  },
  [SET_REQUEST_FULFILLED] (state, index, status, errorText) {
    let request = null
    if (index > 0 < state.all.length) {
      let i = state.pending.indexOf(index)
      if (i >= 0) {
        state.pending.splice(i, 1)
      }
      request = state.all[index]
      if (request) {
        request.status = status
        if (errorText) {
          request.errorText = errorText
        }
      }
    } else {
      throw new RangeError(`No request found at [${index}] index`)
    }
  }
}

export const getters = {
  getByIndex: function (state, index) {
    return state.all[index]
  },
  getLastIndex: function (state) {
    return state.all.length - 1
  },
  isRequestPending: function (state, index) {
    return state.pending.indexOf(index) !== -1
  },
  isPending: function (state) {
    return state.pending.length > 0
  }
}

export const actions = {

  /**
   * Axios request wrapper
   *
   * @callback Request~onSuccessCb
   * @callback Request~onRejectedCb
   * @callback Request~onFinallyCb
   *
   * Request promise events callbacks object
   * @typedef {Object} Request~Callbacks
   * @property {Request~onSuccessCb} onSuccess  - The success callback
   * @property {Request~onRejectedCb} onRejected - The rejected callback
   * @property {equest~onFinallyCb} onFinally - The finally callback
   *
   * @param {function} commit - Vuex.commit
   * @param {Object} state - Vuex.state
   * @param axiosRequestConfig - Axios Request config (https://github.com/axios/axios)
   * @param {Request~Callbacks} callbacks
   * @returns {Promise<AxiosResponse<any>>}
   */
  perform: async function ({commit, state}, axiosRequestConfig, callbacks) {
    let status
    let response = null
    let error = null

    commit(NEW_REQUEST, axiosRequestConfig)
    const index = state.all.length - 1

    /**
     * On success axios promise callback, call the injected onSuccess callback if given
     * @param {Object} response - Axios Response
     * @returns {Object}
     */
    const onSuccess = (response) => {
      status = response.status
      if (callbacks && callbacks.onSuccess) {
        callbacks.onSuccess(response)
      }
      onFinally()
      return response
    }

    /**
     * On rejected axios promise callback, call the injected onRejected callback if given
     * @param e
     * @throws the request reject error
     */
    const onRejected = (e) => {
      status = e.response.status
      error = e
      if (callbacks && callbacks.onRejected) {
        callbacks.onRejected(e)
      }
      onFinally()
      throw error
    }

    /**
     * On finally axios promise callback, call the injected onFinally callback if given
     */
    const onFinally = () => {
      let errorText = ''
      if (error && error.response) {
        errorText = error.response.data
      }
      commit(SET_REQUEST_FULFILLED, index, status, errorText)
      if (callbacks && callbacks.onFinally) {
        callbacks.onFinally(response, error)
      }
    }

    return axios.request(axiosRequestConfig).then(
      onSuccess
    ).catch(
      onRejected
    )
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
