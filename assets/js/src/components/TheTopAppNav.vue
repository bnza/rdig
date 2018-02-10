<template>
    <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <router-link to="/" class="navbar-item">
                <img
                    v-bind:src="rdigLogoSrc"
                    alt="rDig *dig reloaded"
                    width="112" height="28"
                />
            </router-link>
            <button class="button navbar-burger">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
        <div class="navbar-menu">
            <div class="navbar-start">
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        Tables
                    </a>
                    <div class="navbar-dropdown">
                        <router-link
                            class="navbar-item"
                            v-bind:to="{ name: 'data_list', params: { routePrefix: 'data', tableName: 'site', action: 'read' }}"
                        >Site</router-link>
                    </div>
                </div>
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <AdminDropDownMenu
                        v-if="$store.getters['account/isAdmin']"
                    />
                    <UserDropDownMenu
                        v-if="$store.getters['account/isAuthenticated']"
                    />
                    <router-link v-else class="navbar-item" title="Login" v-bind:to="{ name: 'login' }">
                        <span class="icon is-medium">
                            <i class="fa fa-2x fa-sign-in"></i>
                        </span>
                    </router-link>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
  import UserDropDownMenu from './UserDropDownMenu'
  import AdminDropDownMenu from './AdminDropdownMenu'
  export default {
    components: {UserDropDownMenu, AdminDropDownMenu},
    computed: {
      rdigLogoSrc() {
        return require('~/assets/images/rdig_logo_light.png')
      }
    },
    name: "TheTopAppNav"
  }
</script>

<style scoped>

</style>
