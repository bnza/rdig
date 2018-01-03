<template>
    <div class="modal" :class="{'is-active': isActive}">
        <div class="modal-background" v-on:click="deactivateLoginModal"></div>
        <div class="modal-content">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        Login
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">
                        <form>
                            <div class="field">
                                <label class="label">Username</label>
                                <div class="control has-icons-left">
                                    <input class="input" type="text" placeholder="Insert username...">
                                    <span class="icon is-small is-left">
                                    <i class="fa fa-user"></i>
                                </span>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Password</label>
                                <div class="control">
                                    <input class="input" type="password">
                                </div>
                            </div>
                            <div class="field is-grouped">
                                <div class="control">
                                    <button class="button is-link">Submit</button>
                                </div>
                                <div class="control">
                                    <button class="button is-text" v-on:click="deactivateLoginModal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <button class="modal-close is-large" aria-label="close" v-on:click="deactivateLoginModal"></button>
    </div>
</template>

<script>
  export default {
    computed: {
      isActive () {
        return this.$store.state.account.loginModalIsActive
      }
    },
    methods: {
      deactivateLoginModal: function (message) {
        this.$store.commit('account/toggleLoginModal')
      }
    },
    name: "login-form"
  }
</script>

<style scoped>

</style>