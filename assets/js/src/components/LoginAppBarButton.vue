<template>
    <v-tooltip bottom>
        <v-btn
                data-test="loginButton"
                flat
                slot="activator"
                @click="executeAction"
        >
            {{authMxUsername}}
            <v-icon
                    large
                    :color="roleColor"
            >
                {{ iconText }}
            </v-icon>
        </v-btn>
        <span>{{ actionText }}</span>
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
        return this.authMxIsAuthenticated ? 'perm_identity' : 'exit_to_app'
      },
      actionText () {
        return this.authMxIsAuthenticated ? 'Logout' : 'Login'
      },
      roleColor () {
        return this.$store.getters['account/roleColor']
      }
    },
    methods: {
      openLogoutModal () {
        this.$router.push('/logout')
      },
      openLoginModal () {
        this.uuidMxSet('isDialogOpen', true, 'the-login-modal')
        this.uuidMxSet('fromPath', this.$route.fullPath, 'the-login-modal')
        this.$router.push('/login')
      },
      executeAction () {
        this.authMxIsAuthenticated ? this.openLogoutModal() : this.openLoginModal()
      }
    }
  }
</script>
