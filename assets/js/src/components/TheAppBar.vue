<template>
    <v-toolbar app fixed clipped-left>
        <v-toolbar-side-icon @click.native="isNavigationDrawerOpen = !isNavigationDrawerOpen"/>
        <span class="title ml-3 mr-5"><img
            v-bind:src="rdigLogoSrc"
            alt="rDig *dig reloaded"
            width="112" height="28"
        /></span>
    </v-toolbar>
</template>

<script>
  import UuidMx from '../mixins/UuidMx'
  export default {
    name: 'the-app-bar',
    mixins: [
      UuidMx
    ],
    computed: {
      isNavigationDrawerOpen: {
        get: function () {
          return this.$_UuidMx_get('isNavigationDrawerOpen', 'the-right-navigation-drawer')
        },
        set: function (value) {
          this.$_UuidMx_set('isNavigationDrawerOpen', value, 'the-right-navigation-drawer')
        }
      },
      rdigLogoSrc() {
        return require('~/assets/images/rdig_logo_light.png')
      }
    }
  }
</script>