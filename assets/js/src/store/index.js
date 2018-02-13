import Vue from 'vue'
import Vuex from 'vuex'
import account from './account'
import requests from './requests'
import messages from './messages'

Vue.use(Vuex)

const SET_MODAL = 'SET_MODAL'
const CLEAR_MODAL = 'CLEAR_MODAL'

const store = new Vuex.Store({
  state: {
    panelLeftComponent: 'test-left',
    modal: {
      component: null,
      active: false,
      props: null
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
    },
    [SET_MODAL] (state, modalComponent) {
      state.modal.component = modalComponent
    },
    [CLEAR_MODAL] (state) {
      state.modal.component = null
    }
  },
  getters: {
    hasModal: (state) => {
      return state.modal.component
    }
  }
})

export default store
