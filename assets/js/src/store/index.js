import Vue from 'vue'
import Vuex from 'vuex'
import account from './account'
import requests from './requests'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    panelLeftComponent: 'test-left',
    message: {
      body: '',
      className: ''
    }
  },
  modules: {
    account: account,
    requests: requests
  },
  mutations: {
    switchLeftComponent (state, component) {
      state.panelLeftComponent = component
    },
    setMessage (state, body, className) {
      let message = {
        body: body,
        className: className ? className : 'is-primary'
      }
      state.message = message
    },
    clearMessage (state) {
      const message = {
        body: '',
        className: ''
      }
      state.message = message
    }
  }
})

export default store
