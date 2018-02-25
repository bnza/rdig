<template>
    <div class="field is-horizontal">
        <div class="field-label is-normal">
            <label v-if="label" class="label">{{label}}</label>
        </div>
        <div class="field-body">
            <component
                v-bind:fieldKey="fieldKey"
                v-bind:grouped="grouped"
                v-bind:violations="violations"
                v-bind:is="formFieldComponent"
            >
                <slot />
            </component>
        </div>
    </div>
</template>

<script>
  import BaseFormField from './BaseFormField'

  export default {
    name: "horizontal-form-field",
    components: {
      BaseFormField
    },
    props: {
      violations: {
        type: Object
      },
      label: {
        type: String,
        default: ''
      },
      grouped: {
        type: Boolean,
        default: false
      },
      fieldKey: {
        type: String
      },
      formFieldComponent: {
        type: String,
        default: function () {
          return 'base-form-field'
        }
      }
    }

  }
</script>

<style scoped>

</style>