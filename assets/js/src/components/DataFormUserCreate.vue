<template>
    <form>
        <FormField label="Username" v-bind:helpMessage="fieldMessages.username">
            <input v-model="formData.username" class="input is-primary" type="text" placeholder="Text input">
        </FormField>
        <FormField label="Password" v-bind:helpMessage="fieldMessages.password">
            <input v-model="formData.password" class="input is-primary" type="password" placeholder="Text input">
        </FormField>
        <FormField label="Password (again)" v-bind:helpMessage="fieldMessages.passwordCheck">
            <input v-model="passwordCheck" class="input is-primary" type="password" placeholder="Text input">
        </FormField>
        <FormField class="is-grouped">
            <button
                v-bind:disabled="!isValid"
                type="button"
                v-on:click="submitRequest"
                class="button is-link"
                v-bind:class="{'is-loading': isRequestPending}"
            >Submit</button>
            <button
                type="button"
                class="button is-text"
                v-on:click="back"
            >Cancel</button>
        </FormField>
    </form>
</template>

<script>
  import FormField from './FormField'
  import FormControl from './FormControl'
  import PathHelperMixin from '../mixins/PathHelperMixin'
  import DataFormMixin from '../mixins/DataFormMixin'

  export default {
    props: {
      routePrefix: String,
      tableName: String,
      id: Number,
      action: String,
      method: {
        type: String,
        default: 'post'
      }
    },
    mixins: [
      PathHelperMixin,
      DataFormMixin
    ],
    data: function() {
      return {
        passwordCheck: '',
        formData: {
          username: '',
          password: '',
          roles: ['ROLE_USER']
        },
        fieldMessages: {
          username: {},
          password: {},
          passwordCheck: {}
        }
      }
    },
    computed: {
      isValid: function () {
        return this.validate().length === 0
      }
    },
    methods: {
      validate: function () {
        let violations = []
        if (this.formData.username === '') {
          violations.push({
            property: 'username',
            message: 'This value should not be blank.'
          })
        } else if (this.formData.username.length < 8) {
          violations.push({
            property: 'username',
            message: 'This value should be almost 8 character length'
          })
        }
        if (this.formData.password === '') {
          violations.push({
            property: 'password',
            message: 'This value should not be blank.'
          })
        } else if (this.formData.password.length < 8) {
          violations.push({
            property: 'password',
            message: 'This value should be almost 8 character length'
          })
        } else if (this.formData.password !== this.passwordCheck) {
          violations.push({
            property: 'password',
            message: 'Passwords does not match'
          })
          violations.push({
            property: 'passwordCheck',
            message: 'Passwords does not match'
          })
        }
        this.clearErrors()
        this.handleValidationErrors(violations)
        return violations;
      }
    },
    components: {
      FormField,
      FormControl
    },
    name: "DataFormUserCreate"
  }
</script>

<style scoped>

</style>