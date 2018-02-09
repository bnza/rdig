<template>
    <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
            <span class="icon">
                <i class="fa fa-user"></i>
            </span>
            {{ $store.getters['account/username'] }}
        </a>

        <div class="navbar-dropdown">
            <a
                    class="navbar-item"
                    v-on:click="logout"
            >
                <span class="icon has-text-info">
                    <i class="fa fa-sign-out"></i>
                </span>
                Logout
            </a>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'UserDropDownMenu',
    methods: {
      logout: function () {
        this.$store.dispatch('account/logout').then(
          () => {
            if (!this.hasError) {
              this.$router.push({name: 'home'})
            }
          }
        )
      }
    }
  }
</script>

<style scoped>

</style>