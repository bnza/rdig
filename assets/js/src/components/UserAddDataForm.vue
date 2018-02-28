<template>
    <v-form>
        <v-text-field
            label="Username"
            type="text"
            v-model="username"
            :error-messages="usernameErrors"
            :counter="2"
            @input="formMxValidate('username')"
            @blur="formMxValidate('username')"
            :disabled="isRequestPending"
            required
        />
        <v-text-field
            label="Password"
            type="password"
            v-model="password"
            :error-messages="passwordErrors"
            @input="formMxValidate('password')"
            @blur="formMxValidate('password')"
            :disabled="isRequestPending"
            required
        />
        <v-text-field
            label="Password (again)"
            type="password"
            v-model="checkPassword"
            :error-messages="checkPasswordErrors"
            @input="formMxValidate('checkPassword')"
            @blur="formMxValidate('checkPassword')"
            :disabled="isRequestPending"
            required
        />
    </v-form>
</template>

<script>
  import Vue from 'vue'
  import BaseDataForm from './BaseDataForm'
  import { validationMixin } from 'vuelidate'
  import { required, minLength, sameAs } from 'vuelidate/lib/validators'

  export default {
    name: 'user-add-data-form',
    extends: BaseDataForm,
    mixins: [
      validationMixin
    ],
    data () {
      return {
        prefix_: 'admin',
        table_: 'user',
        checkPassword: ''
      }
    },
    validations: {
      username: { required, minLength: minLength(8) },
      password: { required, minLength: minLength(8) },
      checkPassword: {
        sameAsPassword: sameAs('password')
      }
    },
    computed: {
      username: {
        get () {
          return this.item.username
        },
        set (value) {
          Vue.set(this.item, 'username', value)
        }
      },
      password: {
        get () {
          return this.item.password
        },
        set (value) {
          Vue.set(this.item, 'password', value)
        }
      },
      usernameErrors () {
        const errors = []
        if (!this.$v.username.$dirty) return errors
        !this.$v.username.minLength && errors.push('Username must be almost 8 character long.')
        !this.$v.username.required && errors.push('Username is required.')
        return errors
      },
      passwordErrors () {
        const errors = []
        if (!this.$v.password.$dirty) return errors
        !this.$v.password.minLength && errors.push('Password must be almost 8 character long.')
        !this.$v.password.required && errors.push('Password is required.')
        return errors
      },
      checkPasswordErrors () {
        const errors = []
        if (!this.$v.checkPassword.$dirty) return errors
        !this.$v.checkPassword.sameAsPassword && errors.push('Passwords does not match.')
        return errors
      }
    }
  }
</script>