export default {
  namespaced: true,
  state: {
    loginModalIsActive: false
  },
  mutations: {
    toggleLoginModal (state) {
      state.loginModalIsActive = !state.loginModalIsActive
    }
  }
}
