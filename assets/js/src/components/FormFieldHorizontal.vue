<template>
    <div class="field is-horizontal">
        <div v-if="label" class="field-label is-normal">
            <label class="label">{{label}}</label>
        </div>
        <div class="field-body">
            <FormField v-bind:helpMessage="helpMessage">
                <slot></slot>
            </FormField>
        </div>
    </div>
    
</template>

<script>
  import FormField from './FormField'

  export default {
    components: {
      FormField
    },
    props: {
      label: {
        type: String,
        default: ''
      },
      helpMessage: {
        type: Object,
        default: function () {
          return {
            message: '',
            className: ''
          }
        }
      }
    },
    name: "FormFieldHorizontal"
  }
</script>

<style scoped>

</style>