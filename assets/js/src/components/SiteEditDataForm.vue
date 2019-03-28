<template>
    <v-form>
        <v-text-field
            label="Code"
            v-model="item.code"
            :error-messages="validationErrors.code"
            mask="AA"
            :counter="2"
            :disabled="isRequestPending"
            required
        />
        <v-text-field
            label="Name"
            type="text"
            v-model="item.name"
            :error-messages="validationErrors.name"
            :disabled="isRequestPending"
            required
        />
    </v-form>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import { validationMixin } from 'vuelidate'
  import { required, minLength, maxLength } from 'vuelidate/lib/validators'

  const codeErrors = ($v) => {
    const errors = []
    !$v.item.code.minLength && errors.push('Site code must be exactly 2 characters long')
    !$v.item.code.maxLength && errors.push('Site code must be exactly 2 characters long')
    !$v.item.code.required && errors.push('Site code is required.')
    return errors
  }

  const nameErrors = ($v) => {
    const errors = []
    !$v.item.name.required && errors.push('Site name is required.')
    return errors
  }

  export default {
    name: 'site-edit-data-form',
    extends: BaseDataForm,
    mixins: [
      validationMixin
    ],
    validations: {
      item: {
        code: { required, minLength: minLength(2), maxLength: maxLength(2) },
        name: { required }
      }
    },
    computed: {
      validationErrors() {
        return {
          code: codeErrors(this.$v),
          name: nameErrors(this.$v),
        }
      },
    }
  }
</script>
