<template>
    <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <router-link to="/" class="navbar-item">
                <img v-bind:src="rdigLogoSrc" alt="rDig *dig reloaded" width="112" height="28">
            </router-link>
            <button class="button navbar-burger">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>
</template>

<script>
  export default {
    computed: {
      rdigLogoSrc () {
        return require('~/assets/images/rdig.png')
      }
    },
    name: "app-nav-top"
  }
</script>

<style scoped>

</style>