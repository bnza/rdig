<template>
    <v-navigation-drawer
        clipped
        :value="isNavigationDrawerOpen"
        app >
        <v-list
            dense
            class="grey lighten-4"
        >
            <v-list-tile
                @click="openLoginModal"
            >
                <v-list-tile-action>
                    <v-icon>perm_identity</v-icon>
                    <v-list-tile-content>
                        <v-list-tile-title class="grey--text">
                            Login
                        </v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile-action>
            </v-list-tile>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
  import UuidMx from '../mixins/UuidMx'

  export default {
    name: 'the-right-navigation-drawer',
    mixins: [
      UuidMx
    ],
    computed: {
      isNavigationDrawerOpen: function () {
        return !!this.$_UuidMx_get('isNavigationDrawerOpen')
      }
    },
    methods: {
      openLoginModal () {
        this.$_UuidMx_set('isDialogOpen', true, 'the-login-modal').then(
          (uuid) => {
            this.$router.push('/login')
          }
/*          this.$router.push('/login', () => {
            this.$_UuidMx_set('isDialogOpen', true, 'the-login-modal')
          })*/
        )
      }
    }
  }
</script>