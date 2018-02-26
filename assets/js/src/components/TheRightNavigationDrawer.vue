<template>
    <v-navigation-drawer
        clipped
        :value="isNavigationDrawerOpen"
        app >
        <v-list
            dense
            class="grey lighten-4"
        >
            <nav-table-list-group />
            <nav-login-list-tile />
        </v-list>
    </v-navigation-drawer>
</template>

<script>
  import UuidMx from '../mixins/UuidMx'
  import NavLoginListTile from './NavLoginListTile'
  import NavTableListGroup from './NavTableListGroup'

  export default {
    name: 'the-right-navigation-drawer',
    components: {
      NavLoginListTile,
      NavTableListGroup
    },
    mixins: [
      UuidMx
    ],
    computed: {
      isNavigationDrawerOpen: function () {
        return !!this.$_UuidMx_get('isNavigationDrawerOpen')
      }
    }
  }
</script>