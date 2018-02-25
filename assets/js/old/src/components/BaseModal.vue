<template>
    <div class="modal" v-bind:class="{'is-active': active}">
        <div class="modal-background" v-on:click="$emit('close')"></div>
        <slot />
    </div>
</template>

<script>
  export default {
    name: "base-modal",
    props: {
      active: {
        type: Boolean,
        required: true
      }
    }
  }
</script>

<style scoped>

</style>