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
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <a
                            class="navbar-item"
                            title="Login"
                            v-on:click="showLoginModal"
                    >
                        <span class="icon is-medium">
                            <i class="fa fa-2x fa-sign-in"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
  export default {
    computed: {
      rdigLogoSrc() {
        return require('~/assets/images/rdig.png')
      }
    },
    methods: {
      showLoginModal: function () {
        this.$router.push('login')
      }
    },
    name: "TheTopAppNav"
  }
</script>

<style scoped>

</style>