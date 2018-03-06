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
    name: "MainHome"
  }
</script>

<style scoped>

</style>