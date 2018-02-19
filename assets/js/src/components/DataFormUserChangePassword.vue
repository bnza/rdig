<template>
    <form>
        <header>
            <slot name="header" />
        </header>
        <main>
            <slot>
                <horizontal-form-field
                    fieldKey="username"
                    label="username"
                >
                    <static-form-input
                        type="text"
                        v-bind:data="userData.username"
                        v-bind:isRequestPending="isRequestPending"
                    />
                </horizontal-form-field>
                <horizontal-form-field
                    fieldKey="oldPassword"
                    label="Old Password"
                    v-bind:violations="violations"
                    v-bind:isRequestPending="isRequestPending"
                >
                    <base-form-input
                        type="password"
                        fieldKey="oldPassword"
                        v-bind:data="data"
                        v-bind:isRequestPending="isRequestPending"
                    />
                </horizontal-form-field>
                <horizontal-form-field
                    fieldKey="newPassword"
                    label="New Password"
                    v-bind:violations="violations"
                    v-bind:isRequestPending="isRequestPending"
                >
                    <base-form-input
                        type="password"
                        fieldKey="newPassword"
                        v-bind:data="data"
                        v-bind:isRequestPending="isRequestPending"
                    />
                </horizontal-form-field>
                <horizontal-form-field
                    fieldKey="passwordCheck"
                    label="New Password (again)"
                    v-bind:violations="violations"
                    v-bind:isRequestPending="isRequestPending"
                >
                    <base-form-input
                        type="password"
                        v-bind:data="localData"
                        fieldKey="passwordCheck"
                        v-bind:isRequestPending="isRequestPending"
                    />
                </horizontal-form-field>
            </slot>
        </main>
        <footer>
            <slot name="footer">
                <horizontal-edit-form-field-button-group
                    v-bind:isRequestPending="isRequestPending"
                    v-bind:isValid="isValid"
                    v-on:back="$emit('close')"
                    v-on:submit="submitChangePasswordRequest"
                />
            </slot>
        </footer>
    </form>
</template>

<script>
  import BaseEditForm from './BaseEditForm'
  import BaseFormInput from './BaseFormInput'
  import StaticFormInput from './StaticFormInput'
  import HorizontalFormField from './HorizontalFormField'
  import HorizontalEditFormFieldButtonGroup from './HorizontalEditFormFieldButtonGroup'

  export default {
    name: "data-form-user-change-password",
    extends: BaseEditForm,
    components:{
      HorizontalFormField,
      BaseFormInput,
      StaticFormInput,
      HorizontalEditFormFieldButtonGroup
    },
    props: {
      userData: {
        type: Object
      }
    },
    data: function () {
      return {
        localData: {
          passwordCheck: ''
        }
      }
    },
    watch: {
      data: {
        handler: function () {
          this.validate()
        },
        deep: true
      },
      localData: {
        handler: function () {
          this.validate()
        },
        deep: true
      }
    },
    computed: {
      isValid: function () {
        return Object.keys(this.violations).length === 0
      }
    },
    methods: {
      submitChangePasswordRequest: function () {
        this.submitRequest({
          method: 'post',
          url: `${this.itemUrl}/change-password`,
          data: this.data
        })
      },
      readData: function () {
        this.data = {
          oldPassword: '',
          newPassword: '',
        }
      },
      validate: function (data) {
        data = data || this.data
        let violations = {}
        for (var i of ['oldPassword','newPassword']) {
          if (data[i] === '') {
            violations[i] = 'This value should not be blank.'
          } else if (data[i].length < 8) {
            violations[i] = 'This value should be almost 8 character length'
          }
        }
        if (data['newPassword'] !== this.localData['passwordCheck']) {
          violations['passwordCheck'] = 'Passwords does not match'
        }

        this.violations = violations
      }
    }
  }
</script>