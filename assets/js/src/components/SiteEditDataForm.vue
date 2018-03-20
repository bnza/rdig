<template>
    <v-form>
        <v-text-field
            label="Code"
            v-model="code"
            :error-messages="codeErrors"
            mask="AA"
            :counter="2"
            @input="formMxValidate('code')"
            @blur="formMxValidate('code')"
            :disabled="isRequestPending"
            required
        />
        <v-text-field
            label="Name"
            type="text"
            v-model="name"
            :error-messages="nameErrors"
            @input="formMxValidate('name')"
            @blur="formMxValidate('name')"
            :disabled="isRequestPending"
            required
        />
    </v-form>
</template>

<script>
  import Vue from 'vue'
  import BaseDataForm from './BaseDataForm'
  import { validationMixin } from 'vuelidate'
  import { required, minLength, maxLength } from 'vuelidate/lib/validators'

  export default {
    name: 'site-edit-data-form',
    extends: BaseDataForm,
    mixins: [
      validationMixin
    ],
    data () {
      return {
        table_: 'site'
      }
    },
    validations: {
      code: { required, minLength: minLength(2), maxLength: maxLength(2) },
      name: { required }
    },
    computed: {
      code: {
        get () {
          return this.item.code
        },
        set (value) {
          Vue.set(this.item_, 'code', value.toUpperCase())
        }
      },
      name: {
        get () {
          return this.item.name
        },
        set (value) {
          Vue.set(this.item, 'name', value)
        }
      },
      codeErrors () {
        const errors = []
        if (!this.$v.code.$dirty) return errors
        !this.$v.code.minLength && errors.push('Site code must be exactly 2 characters long')
        !this.$v.code.maxLength && errors.push('Site code must be exactly 2 characters long')
        !this.$v.code.required && errors.push('Site code is required.')
        return errors
      },
      nameErrors () {
        const errors = []
        if (!this.$v.name.$dirty) return errors
        !this.$v.name.required && errors.push('Site name is required.')
        return errors
      }
    }
  }
</script>