<template>
    <base-edit-form
        ref="editForm"
        v-bind:deferValidation="false"
        v-bind:fetch="false"
        v-on:back="$emit('close')"
    >
        <template v-if="form.data" slot-scope="form">
            <horizontal-form-field
                fieldKey="username"
                label="username"
            >
                <static-form-input
                    type="text"
                    fieldKey="username"
                    v-bind:data="userData"
                    v-bind:isRequestPending="form.isRequestPending"
                />
            </horizontal-form-field>
            <horizontal-form-field
                fieldKey="oldPassword"
                label="Old Password"
                v-bind:violations="form.violations"
                v-bind:isRequestPending="form.isRequestPending"
            >
                <base-form-input
                    type="password"
                    fieldKey="oldPassword"
                    v-bind:data="form.data"
                    v-bind:isRequestPending="form.isRequestPending"
                />
            </horizontal-form-field>
            <horizontal-form-field
                fieldKey="newPassword"
                label="New Password"
                v-bind:violations="form.violations"
                v-bind:isRequestPending="form.isRequestPending"
            >
                <base-form-input
                    type="password"
                    fieldKey="newPassword"
                    v-bind:data="form.data"
                    v-bind:isRequestPending="form.isRequestPending"
                />
            </horizontal-form-field>
            <horizontal-form-field
                fieldKey="passwordCheck"
                label="New Password (again)"
                v-bind:violations="form.violations"
                v-bind:isRequestPending="form.isRequestPending"
            >
                <base-form-input
                    type="password"
                    fieldKey="passwordCheck"
                    v-bind:data="form.data"
                    v-bind:isRequestPending="form.isRequestPending"
                />
            </horizontal-form-field>
        </template>
            <horizontal-edit-form-field-button-group
                slot="footer"
                cancelButtonLabel="Close"
                cancelButtonEmit="close"
                v-bind:isRequestPending="form.isRequestPending"
                v-bind:isValid="form.isValid"
                v-on:close="$emit('close')"
                v-on:submit="submitRequest"
            />
    </base-edit-form>
</template>

<script>
  import BaseEditForm from './BaseEditForm'
  import BaseFormInput from './BaseFormInput'
  import StaticFormInput from './StaticFormInput'
  import HorizontalFormField from './HorizontalFormField'
  import HorizontalEditFormFieldButtonGroup from './HorizontalEditFormFieldButtonGroup'

  export default {
    name: "data-form-user-change-password",
    props: {
      userData: {
        type: Object,
        required: true
      }
    },
    components:{
      BaseEditForm,
      HorizontalFormField,
      BaseFormInput,
      StaticFormInput,
      HorizontalEditFormFieldButtonGroup
    },
    methods: {
      readData: function () {
        this.data = {
          username: this.userData.username,
          oldPassword: '',
          newPassword: '',
          checkPassword: ''
        }
      },
      validate: function () {
        let form = this.$refs.editForm
        if (this.data.oldPassword === '') {
          form.violations.push['oldPassword'] = 'This value should not be blank.'
        } else if (this.data.oldPassword.length < 8) {
          form.violations.push['oldPassword'] = 'This value should be almost 8 character length'
        }
        return !!Object.keys(this.violations).length
      }
    }
  }
</script>