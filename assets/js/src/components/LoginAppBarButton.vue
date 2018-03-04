<template>
    <v-tooltip bottom>
        <v-btn flat slot="activator" @click="executeAction">
            {{authMxUsername}}
            <v-icon large>{{iconText}}</v-icon>
        </v-btn>
        <span>{{actionText}}</span>
    </v-tooltip>
</template>

<script>
  import UuidMx from '../mixins/UuidMx'
  import AuthMx from '../mixins/AuthMx'

  export default {
    name: 'login-app-bar-button',
    mixins: [
      AuthMx,
      UuidMx
    ],
    computed: {
      iconText () {
        return this.$_AuthMx_isAuthenticated ?  'perm_identity' : 'exit_to_app'
      },
      actionText () {
        return this.$_AuthMx_isAuthenticated ?  'Logout' : 'Login'
      }
    },
    methods: {
      logout () {
        this.$store.dispatch('account/logout').then(
          () => {
            if (!this.hasError) {
              this.$router.push('/')
            }
          }
        )
      },
      openLoginModal () {
        this.uuidMxSet('isDialogOpen', true, 'the-login-modal')
        this.uuidMxSet('fromPath', this.$route.fullPath , 'the-login-modal')
        this.$router.push('/login')
      },
      executeAction () {
        this.$_AuthMx_isAuthenticated ? this.logout() : this.openLoginModal()
      }
    }
  }
</script>