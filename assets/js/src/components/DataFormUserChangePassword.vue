<template>
    <form>
        <FormFieldHorizontal label="Username">
            <input class="input is-static" type="text" v-model="formData.username" readonly>
        </FormFieldHorizontal>
        <FormFieldHorizontal v-if="!$store.getters['account/isAdmin']" label="Old password" v-bind:helpMessage="fieldMessages.oldPassword">
            <input v-model="formData.oldPassword" class="input is-primary" type="password" placeholder="Text input">
        </FormFieldHorizontal>
        <FormFieldHorizontal label="New password" v-bind:helpMessage="fieldMessages.newPassword">
            <input v-model="formData.newPassword" class="input is-primary" type="password" placeholder="Text input">
        </FormFieldHorizontal>
        <FormFieldHorizontal label="New password (again)" v-bind:helpMessage="fieldMessages.passwordCheck">
            <input v-model="passwordCheck" class="input is-primary" type="password" placeholder="Text input">
        </FormFieldHorizontal>
        <FormFieldHorizontal label="-" class="is-grouped">
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
        </FormFieldHorizontal>
    </form>
</template>

<script>
  import FormFieldHorizontal from './FormFieldHorizontal'
  import FormControl from './FormControl'
  import PathHelperMixin from '../mixins/PathHelperMixin'
  import DataFormMixin from '../mixins/DataFormMixin'

  export default {
    props: {
      routePrefix: String,
      tableName: String,
      id: Number,
      action: String
    },
    mixins: [
      PathHelperMixin,
      DataFormMixin
    ],
    data: function() {
      return {
        passwordCheck: '',
        formData: {
          oldPassword: '',
          newPassword: '',
          password: '',
        },
        fieldMessages: {
          oldPassword: {},
          newPassword: {},
          passwordCheck: {}
        }
      }
    },
    computed: {
      isValid: function () {
        return this.validate().length === 0
      },
      submitUrl: function () {
        return `${this.itemUrl}/change-password`
      }
    },
    created () {
      this.readData()
    },
    methods: {
      validate: function () {
        let violations = []

        //Old password is needed only by non admin users
        if (!this.$store.getters['account/isAdmin']) {
          if (this.formData.oldPassword === '') {
            violations.push({
              property: 'oldPassword',
              message: 'This value should not be blank.'
            })
          } else if (this.formData.oldPassword.length < 8) {
            violations.push({
              property: 'oldPassword',
              message: 'This value should be almost 8 character length'
            })
          }
        }

        if (this.formData.newPassword === '') {
          violations.push({
            property: 'newPassword',
            message: 'This value should not be blank.'
          })
        } else if (this.formData.newPassword.length < 8) {
          violations.push({
            property: 'newPassword',
            message: 'This value should be almost 8 character length'
          })
        } else if (this.formData.newPassword !== this.passwordCheck) {
          violations.push({
            property: 'newPassword',
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
      FormFieldHorizontal,
      FormControl
    },
    name: "DataFormChangePassword"
  }
</script>

<style scoped>

</style>