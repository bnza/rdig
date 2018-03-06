<template>
    <form v-if="uuid">
        <component
            v-for="(config, fieldKey) in fields"
            v-bind:key="fieldKey"
            ref="'field-'+fieldKey"
            v-bind:is="fieldComponent(fieldKey)"
            v-bind:uuid="uuid"
            v-bind:fieldKey="fieldKey"
        >
        </component>
    </form>
</template>

<script>
  import BaseForm from './BaseForm'

  export default {
    name: "data-form-site-read",
    extends: BaseForm,
    data: function () {
      return {
        formConfigObject: {
          fields: {
            id: {
              input: {
                states: [
                  'is-static'
                ]
              }
            },
            code: {
              input: {
                states: [
                  'is-static'
                ]
              }
            },
            name: {
              input: {
                states: [
                  'is-static'
                ]
              }
            }
          }
        }
      }
    }
  }
</script>

<style scoped>

</style>