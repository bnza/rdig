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
            <nav-admin-list-group v-if="authMxIsAdmin"/>
            <nav-login-list-tile />
        </v-list>
    </v-navigation-drawer>
</template>

<script>
  import AuthMx from '../mixins/AuthMx'
  import UuidMx from '../mixins/UuidMx'
  import NavLoginListTile from './NavLoginListTile'
  import NavTableListGroup from './NavTableListGroup'
  import NavAdminListGroup from './NavAdminListGroup'

  export default {
    name: 'the-right-navigation-drawer',
    components: {
      NavLoginListTile,
      NavTableListGroup,
      NavAdminListGroup
    },
    mixins: [
      UuidMx,
      AuthMx
    ],
    computed: {
      isNavigationDrawerOpen: function () {
        return !!this.uuidMxGet('isNavigationDrawerOpen')
      }
    }
  }
</script>