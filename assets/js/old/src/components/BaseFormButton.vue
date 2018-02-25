<template>
    <button
        class="button"
        v-bind:class="{'is-loading': isRequestPending}"
        v-bind:disabled="isRequestPending || !isValid"
        v-on:click="$emit('click')"
    >{{label}}</button>
</template>

<script>
  export default {
    name: "base-form-button",
    props: {
      label: {
        type: String,
        required: true
      },
      isRequestPending: {
        type: Boolean,
        default: false
      },
      isValid: {
        type: Boolean,
        default: true
      }
    }
  }
</script>

<style scoped>

</style>