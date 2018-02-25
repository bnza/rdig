<template>
    <horizontal-form-field v-bind:grouped="true">
        <base-button-control>
            <base-form-button v-bind:label="cancelButtonLabel" v-on:click="$emit(cancelButtonEmit)"/>
        </base-button-control>
        <base-button-control>
            <base-form-button
                v-bind:label="actionButtonLabel"
                class="is-link"
                v-bind:isValid="isValid"
                v-bind:isRequestPending="isRequestPending"
                v-on:click="$emit(actionButtonEmit)"
            />
        </base-button-control>
    </horizontal-form-field>
</template>

<script>
  import HorizontalFormField from './HorizontalFormField'
  import BaseButtonControl from './BaseButtonControl'
  import BaseFormButton from './BaseFormButton'
  export default {
    name: 'horizontal-edit-form-field-button-group',
    components: {
      HorizontalFormField,
      BaseButtonControl,
      BaseFormButton
    },
    props: {
      isRequestPending: {
        type: Boolean,
        default: function () {
          return false
        }
      },
      isValid: {
        type: Boolean,
        default: function () {
          return false
        }
      },
      cancelButtonLabel: {
        type: String,
        default: function () {
          return 'Back'
        }
      },
      cancelButtonEmit: {
        type: String,
        default: function () {
          return 'back'
        }
      },
      actionButtonLabel: {
        type: String,
        default: function () {
          return 'Submit'
        }
      },
      actionButtonEmit: {
        type: String,
        default: function () {
          return 'submit'
        }
      },
    }
  }
</script>

<style scoped>

</style>