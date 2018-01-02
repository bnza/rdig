<template>
    <img v-bind:src="rdigLogoDarkSrc" alt="rDig *dig reloaded">
</template>

<script>
  export default {
    computed: {
      rdigLogoDarkSrc() {
        return require('~/assets/images/rdig_dark.png')
      }
    },
    name: "home-main"
  }
</script>

<style scoped>

</style>