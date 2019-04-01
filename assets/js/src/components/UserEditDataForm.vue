<template>
    <v-form>
        <v-container>
            <v-layout row wrap>
                <v-text-field
                    readonly
                    label="Username"
                    type="text"
                    v-model="item.username"
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
        </v-container>
    </v-form>
</template>

<script>
  import Vue from 'vue'
  import BaseDataForm from './BaseDataForm'
  import {validationMixin} from 'vuelidate'
  import {required, minLength, sameAs} from 'vuelidate/lib/validators'

  export default {
    name: 'user-edit-data-form',
    extends: BaseDataForm,
    mixins: [
      validationMixin
    ],
    data() {
      return {
        prefix_: 'admin',
        table_: 'user'
      }
    },
    validations: {
      item: {
        username: {required, minLength: minLength(8)},
        roles: {}
      }
    },
    computed: {
      roles() {
        let roles = this.item.roles || [];
        if (roles) {
          roles = typeof roles === 'string' ? roles.split(',') : roles
        }
        return roles
      },
      admin: {
        get() {
          return this.roles.indexOf('ROLE_ADMIN') > -1
        },
        set(value) {
          let roles = this.roles
          const index = roles.indexOf('ROLE_ADMIN')
          if (value) {
            if (index === -1) {
              roles.push('ROLE_ADMIN');
            }
          } else {
            if (index > -1) {
              roles.splice(index, 1);
            }
          }
          Vue.set(this.item, 'roles', roles)
        }
      },
      superuser: {
        get() {
          return this.roles.indexOf('ROLE_SUPER_USER') > -1
        },
        set(value) {
          let roles = this.roles
          const index = roles.indexOf('ROLE_SUPER_USER')
          if (value) {
            if (index === -1) {
              roles.push('ROLE_SUPER_USER');
            }
          } else {
            if (index > -1) {
              roles.splice(index, 1);
            }
          }
          Vue.set(this.item, 'roles', roles)
        }
      }
    },
    watch: {
      item: {
        handler(newValue, oldValue) {
          if (newValue && newValue !== oldValue) {
            this.uuidMxSet('isInvalid', this.formMxIsInvalid, this.$_FormMx_uuid)
          }
        },
        deep: true
      }
    }
  }
</script>
