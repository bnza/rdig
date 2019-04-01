<template>
    <v-form>
        <v-container>
            <v-layout row wrap>
                <v-text-field
                    label="Username"
                    type="text"
                    v-model="item.username"
                    :error-messages="usernameErrors"
                    :counter="8"
                    :disabled="isRequestPending"
                    required
                />
            </v-layout>
            <v-layout row wrap>
                <v-flex xs6>
                    <v-checkbox
                        label="Superuser"
                        v-model="superuser"
                    />
                </v-flex>
                <v-flex xs6>
                    <v-checkbox
                        label="Admin"
                        v-model="admin"
                    />
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-text-field
                    label="Password"
                    type="password"
                    v-model="item.password"
                    :error-messages="passwordErrors"
                    :counter="8"
                    :disabled="isRequestPending"
                    required
                />
            </v-layout>
            <v-layout row wrap>
                <v-text-field
                    label="Password (again)"
                    type="password"
                    v-model="checkPassword"
                    :error-messages="checkPasswordErrors"
                    :disabled="isRequestPending"
                    required
                />
            </v-layout>
        </v-container>
    </v-form>
</template>

<script>
  import Vue from 'vue'
  import BaseDataForm from './BaseDataForm'
  import {validationMixin} from 'vuelidate'
  import {required, minLength, sameAs} from 'vuelidate/lib/validators'

  export default {
    name: 'user-add-data-form',
    extends: BaseDataForm,
    mixins: [
      validationMixin
    ],
    data() {
      return {
        prefix_: 'admin',
        table_: 'user',
        checkPassword: '',
      }
    },
    validations: {
      item: {
        username: {required, minLength: minLength(8)},
        password: {required, minLength: minLength(8)},
      },
      checkPassword: {
        sameAsPassword: sameAs(function() { return this.item.password })
      }
    },
    computed: {
      admin: {
        get() {
          return this.item.roles && (this.item.roles.indexOf('ROLE_ADMIN') > -1)
        },
        set(value) {
          let roles = this.item.roles || []
          const index = roles.indexOf('ROLE_ADMIN')
          if (value) {
            if (index === -1) {
              roles.push('ROLE_ADMIN');
            }
          } else {
            if (index > -1) {
              roles.splice(index);
            }
          }
          Vue.set(this.item, 'roles', roles)
        }
      },
      superuser: {
        get() {
          return this.item.roles && (this.item.roles.indexOf('ROLE_SUPER_USER') > -1)
        },
        set(value) {
          let roles = this.item.roles || []
          const index = roles.indexOf('ROLE_SUPER_USER')
          if (value) {
            if (index === -1) {
              roles.push('ROLE_SUPER_USER');
            }
          } else {
            if (index > -1) {
              roles.splice(index);
            }
          }
          Vue.set(this.item, 'roles', roles)
        }
      },
      usernameErrors() {
        const errors = []
        !this.$v.item.username.minLength && errors.push('Username must be almost 8 character long.')
        !this.$v.item.username.required && errors.push('Username is required.')
        return errors
      },
      passwordErrors() {
        const errors = []
        !this.$v.item.password.minLength && errors.push('Password must be almost 8 character long.')
        !this.$v.item.password.required && errors.push('Password is required.')
        return errors
      },
      checkPasswordErrors() {
        const errors = []
        !this.$v.checkPassword.sameAsPassword && errors.push('Passwords does not match.')
        return errors
      }
    }
  }
</script>
