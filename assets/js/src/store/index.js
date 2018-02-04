import Vue from 'vue'
import Vuex from 'vuex'
import account from './account'
import requests from './requests'
import messages from './messages'

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
    requests: requests,
    messages: messages
  },
  mutations: {
    switchLeftComponent (state, component) {
      state.panelLeftComponent = component
    }
  }
})

export default store
