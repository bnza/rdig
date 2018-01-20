<template>
    <form>
        <FormField label="Code" v-bind:helpMessage="fieldMessages.code">
            <input v-model="form.code" class="input is-primary" type="text" placeholder="Text input">
        </FormField>
        <FormField label="Name" v-bind:helpMessage="fieldMessages.name">
            <input v-model="form.name" class="input is-primary" type="text" placeholder="Text input">
        </FormField>
        <FormField class="is-grouped">
            <button
                type="button"
                v-on:click="submit"
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
    mixins: [
      DataFormMixin
    ],
    data: function() {
      return {
        form: {
          code: '',
          name: ''
        },
        isRequestPending: false,
        fieldMessages: {
          code: {},
          name: {}
        }
      }
    },
    components: {
      FormField,
      FormControl
    },
    methods: {
      submit: function() {
        let config = {
          method: 'post',
          url: 'data/site',
          data: this.form
        }
        let successCb = function (response, component) {
          component.$router.replace(`/data/site/${response.data.id}/read`)
        }
        this.performRequest(config, successCb)
      }
    },
    name: "DataFormSiteCreate"
  }
</script>

<style scoped>

</style>