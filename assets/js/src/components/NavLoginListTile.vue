<template>
    <v-list
        dense
        class="grey lighten-4"
    >
        <v-list-tile
            @click="executeAction"
        >
            <v-list-tile-action>
                <v-icon>{{iconText}}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>
                    {{actionText}}
                </v-list-tile-title>
            </v-list-tile-content>

        </v-list-tile>
    </v-list>
</template>

<script>
  import UuidMx from '../mixins/UuidMx'
  import AuthMx from '../mixins/AuthMx'

  export default {
    name: 'nav-login-list-tile',
    mixins: [
      AuthMx,
      UuidMx
    ],
    computed: {
      iconText () {
        return this.authMxIsAuthenticated ?  'perm_identity' : 'exit_to_app'
      },
      actionText () {
        return this.authMxIsAuthenticated ?  'Logout' : 'Login'
      }
    },
    methods: {
      openLogoutModal () {
        this.$router.push('/logout')
      },
      openLoginModal () {
        this.uuidMxSet('isDialogOpen', true, 'the-login-modal')
        this.uuidMxSet('fromPath', this.$route.fullPath , 'the-login-modal')
        this.$router.push('/login')
      },
      executeAction () {
        this.authMxIsAuthenticated ? this.openLogoutModal() : this.openLoginModal()
      }
    }
  }
</script>