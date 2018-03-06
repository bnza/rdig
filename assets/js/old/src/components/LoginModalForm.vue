<template>
    <form>
        <div class="field">
            <label class="label">Username</label>
            <div class="control has-icons-left">
                <input
                    v-bind:disabled="isRequestPending"
                    v-model="username"
                    class="input"
                    type="text"
                    placeholder="Insert username..."
                >
                <span class="icon is-small is-left">
                    <i class="fa fa-user"></i>
                </span>
            </div>
        </div>
        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input v-model="password" class="input" type="password">
            </div>
        </div>
        <article v-if="hasError" class="message is-danger">
            <div class="message-body">{{authError}}</div>
        </article>
        <div class="field is-grouped">
            <div class="control">
                <button
                    type="button"
                    v-bind:disabled="isButtonDisabled"
                    v-on:click="performLogin"
                    class="button is-link"
                    v-bind:class="{'is-loading': isRequestPending}"
                >
                    Submit
                </button>
            </div>
            <div class="control">
                <button
                    v-bind:disabled="isRequestPending"
                    type="button"
                    class="button is-text"
                    v-on:click="cancel"
                >
                    Cancel
                </button>
            </div>
        </div>
    </form>
</template>

<script>
  import qs from 'qs'

  export default {
    data: function () {
      return {
        username: '',
        password: ''
      }
    },
    computed: {
      isValid () {
        return 0 < this.username.length && 0 < this.password.length
      },
      isButtonDisabled () {
        return !this.isValid || this.isRequestPending
      },
      isRequestPending () {
        return this.$store.state.account.requestPending
      },
      authError () {
        return this.$store.getters['account/errorMessage']
      },
      hasError () {
        return this.$store.getters['account/hasError']
      }
    },
    methods: {
      cancel: function () {
        this.$emit('cancel')
      },
      performLogin: function () {
        const credentials = qs.stringify({
          username: this.username,
          password: this.password
        });
        this.$store.dispatch('account/login', credentials).then(
          () => {
            if (!this.hasError) {
              this.$router.back()
            }
          }
        ).catch(
          () => {
            console.warn('Login failed')
          }
        )
      }
    },
    name: "login-form"
  }
</script>

<style scoped>

</style>