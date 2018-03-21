<template>
    <v-toolbar app fixed clipped-left>
        <v-toolbar-side-icon @click.native="isNavigationDrawerOpen = !isNavigationDrawerOpen"/>
        <v-toolbar-title>
            <router-link to="/" replace>
            <span class="title ml-3 mr-5"><img
                v-bind:src="rdigLogoSrc"
                alt="rDig *dig reloaded"
                width="112" height="28"
            /></span>
            </router-link>
        </v-toolbar-title>
        <v-spacer/>
        <v-toolbar-items>
            <login-app-bar-button />
        </v-toolbar-items>
    </v-toolbar>
</template>

<script>
  import UuidMx from '../mixins/UuidMx'
  import LoginAppBarButton from './LoginAppBarButton'
  export default {
    name: 'the-app-bar',
    components: {
      LoginAppBarButton
    },
    mixins: [
      UuidMx
    ],
    computed: {
      isNavigationDrawerOpen: {
        get: function () {
          return this.uuidMxGet('isNavigationDrawerOpen', 'the-right-navigation-drawer')
        },
        set: function (value) {
          this.uuidMxSet('isNavigationDrawerOpen', value, 'the-right-navigation-drawer')
        }
      },
      rdigLogoSrc() {
        return require('~/assets/images/rdig_logo_light.png')
      }
    }
  }
</script>