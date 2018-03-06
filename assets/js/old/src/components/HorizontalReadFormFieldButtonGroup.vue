<template>
    <horizontal-form-field v-bind:grouped="true">
        <base-button-control>
            <base-form-button label="Back" v-on:click="$emit('back')"/>
        </base-button-control>
        <base-button-control>
            <base-form-button label="Edit" class="is-link" v-on:click="$emit('edit')"/>
        </base-button-control>
        <base-button-control>
            <base-form-button label="Delete" class="is-danger" v-on:click="$emit('delete')"/>
        </base-button-control>
    </horizontal-form-field>
</template>

<script>
  import HorizontalFormField from './HorizontalFormField'
  import BaseButtonControl from './BaseButtonControl'
  import BaseFormButton from './BaseFormButton'
  export default {
    name: 'horizontal-read-form-field-button-group',
    components: {
      HorizontalFormField,
      BaseButtonControl,
      BaseFormButton
    }
  }
</script>

<style scoped>

</style>