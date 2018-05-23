<template>
    <v-navigation-drawer
        clipped
        :hide-overlay="true"
        :value="isNavigationDrawerOpen"
        app >
        <v-list
            dense
            class="grey lighten-4"
        >
            <nav-table-list-group />
            <nav-user-list-group v-if="authMxIsAuthenticated"/>
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
  import NavUserListGroup from './NavUserListGroup'
  import NavAdminListGroup from './NavAdminListGroup'

  export default {
    name: 'the-right-navigation-drawer',
    components: {
      NavLoginListTile,
      NavTableListGroup,
      NavAdminListGroup,
      NavUserListGroup
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