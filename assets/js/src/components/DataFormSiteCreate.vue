<template>
    <form>
        <FormField label="Code" v-bind:helpMessage="fieldMessages.code">
            <FormControl>
                <input v-model="from.code" class="input is-primary" type="text" placeholder="Text input">
            </FormControl>
        </FormField>
        <FormField label="Name" v-bind:helpMessage="fieldMessages.name">
            <FormControl >
                <input v-model="from.name" class="input is-primary" type="text" placeholder="Text input">
            </FormControl>
        </FormField>
        <FormField class="is-grouped">
            <FormControl>
                <button
                    v-on:click="performRequest"
                    class="button is-link"
                    v-bind:class="{'is-loading': isRequestPending}"
                >Submit</button>
            </FormControl>
            <FormControl>
                <button class="button is-text">Cancel</button>
            </FormControl>
        </FormField>
    </form>
</template>

<script>
  import FormField from './FormField'
  import FormControl from './FormControl'
  import Vue from 'vue'

  export default {
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
      clearErrors: function () {
        for (let prop in this.fieldMessages) {
          this.fieldMessages[prop] = {}
        }
      },
      handleErrors: function (reason) {
        if (reason.response) {
          if (reason.response.data && reason.response.data.error) {
            let error = reason.response.data.error
            if (error.violations) {
                for (let i = 0; i < error.violations.length; i++) {
                  let violation = error.violations[i]
                  Vue.set(this.fieldMessages[violation.property] = {
                    className: 'is-danger',
                    message: violation.message
                  })
                  console.log(violation.message)
                }
            }
          }
        }
      },
      performRequest: function () {
        this.clearErrors()
        let config = {
          method: 'post',
          url: 'data/site',
          data: this.form
        }
        this.$store.dispatch('requests/perform', config)
          .then(
            (response) => {
              this.$router.replace(`/data/site/${response.data.id}/read`)
            }
          )
          .catch(
            this.handleErrors
          )
      }
    },
    name: "DataFormSiteCreate"
  }
</script>

<style scoped>

</style>