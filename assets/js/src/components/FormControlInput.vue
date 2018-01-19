<template>
    <input
        class="input"
        v-bind:class="statusClassObject"
        type="text"
        placeholder="Text input"
    >

</template>

<script>
    export default {
      props: {
        status: {
          type: String,
          default: function () {
            return ''
          }
        }
      },
      statusClassObject: function () {
        let classObject = {}
        if (this.status) {
          classObject[this.status] = true
          return classObject
        }
      },
      name: "FormControlInput"
    }
</script>

<style scoped>

</style>