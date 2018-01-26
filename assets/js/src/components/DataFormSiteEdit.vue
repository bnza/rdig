<template>
    <form>
        <FormField label="Code" v-bind:helpMessage="fieldMessages.code">
            <input v-model="formData.code" class="input is-primary" type="text" placeholder="Text input">
        </FormField>
        <FormField label="Name" v-bind:helpMessage="fieldMessages.name">
            <input v-model="formData.name" class="input is-primary" type="text" placeholder="Text input">
        </FormField>
        <FormField class="is-grouped">
            <button
                type="button"
                v-on:click="submitRequest"
                class="button is-link"
                v-bind:class="{'is-loading': isRequestPending}"
            >Submit</button>
            <button class="button is-text">Cancel</button>
        </FormField>
    </form>
</template>

<script>
  import FormField from './FormField'
  import FormControl from './FormControl'
  import DataFormMixin from '../mixins/DataFormMixin'

  export default {
    props: ['method','id'],
    mixins: [
      DataFormMixin
    ],
    created () {
      // Fetch only on update action
      if (this.id) {
        this.readData()
      }
    },
    data: function() {
      return {
        formData: {
          code: '',
          name: ''
        },
        fieldMessages: {
          code: {},
          name: {}
        },
        tableName: 'site'
      }
    },
    components: {
      FormField,
      FormControl
    },
    name: "DataFormSiteEdit"
  }
</script>

<style scoped>

</style>