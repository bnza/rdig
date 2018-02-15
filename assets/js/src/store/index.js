import Vue from 'vue'
import Vuex from 'vuex'
import account from './account'
import requests from './requests'
import messages from './messages'
import components from './components'

Vue.use(Vuex)

const SET_MODAL = 'SET_MODAL'
const CLEAR_MODAL = 'CLEAR_MODAL'

const store = new Vuex.Store({
  state: {
    panelLeftComponent: 'test-left',
    modalComponent: null
  },
  modules: {
    account: account,
    requests: requests,
    messages: messages,
    components: components
  },
  mutations: {
    switchLeftComponent (state, component) {
      state.panelLeftComponent = component
    },
    [SET_MODAL] (state, modalComponent) {
      state.modalComponent = modalComponent
    },
    [CLEAR_MODAL] (state) {
      state.modalComponent = null
    }
  },
  getters: {
    hasModal: (state) => {
      return state.modal
    }
  }
})

export default store
