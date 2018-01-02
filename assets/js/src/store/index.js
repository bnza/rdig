import Vue from 'Vue'
import Vuex from 'Vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    panelLeftComponent: 'test-left'
  },
  mutations: {
    switchLeftComponent (state, component) {
      state.panelLeftComponent = component
    }
  }
})

export default store
