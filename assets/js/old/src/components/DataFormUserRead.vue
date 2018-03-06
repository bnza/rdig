<template>
    <section>
        <article>
            <base-read-form ref="formComponent">
                <data-form-user-change-password-modal
                    v-if="form.data && form.data !== {}"
                    slot-scope="form"
                    slot="other-modals"
                    v-bind:userData="form.data"
                    v-bind:isRequestPending="false"
                    v-bind:active="isChangePasswordModalActive"
                    v-on:close="isChangePasswordModalActive=false"
                    v-on:change="changePassword(...arguments)"
                />
                <template v-if="form.data" slot-scope="form">
                    <horizontal-form-field
                        fieldKey="username"
                        label="username"
                        v-bind:violations="form.violations"
                    >
                        <static-form-input
                            type="text"
                            fieldKey="username"
                            v-bind:data="form.data"
                        />
                    </horizontal-form-field>
                    <horizontal-form-field
                        fieldKey="password"
                        label="password"
                        v-bind:violations="form.violations"
                    >
                        <static-form-input
                            type="password"
                            fieldKey="password"
                            v-bind:data="form.data"
                        />
                    </horizontal-form-field>
                    <horizontal-form-field
                        fieldKey="roles"
                        label="roles"
                        v-bind:violations="form.violations"
                    >
                        <static-form-input
                            type="text"
                            fieldKey="roles"
                            v-bind:data="form.data"
                        />
                    </horizontal-form-field>
                </template>
                <horizontal-form-field
                    slot="footer"
                    slot-scope="form"
                    v-bind:grouped="true"
                >
                    <base-button-control>
                        <base-form-button
                            label="Back"
                            v-bind:isRequestPending="form.isRequestPending"
                            v-on:click="back"
                        />
                    </base-button-control>
                    <base-button-control>
                        <base-form-button
                            label="Change Password"
                            class="is-link"
                            v-on:click="openChangePasswordModal"
                        />
                    </base-button-control>
                    <base-button-control>
                        <base-form-button
                            label="Delete"
                            class="is-danger"
                            v-on:click="openDeleteModal"
                        />
                    </base-button-control>
                </horizontal-form-field>
            </base-read-form>
        </article>
        <child-data-list
            v-bind:parent="{table:$route.params.table, id:$route.params.id}"
            v-bind:route="{table: 'user-allowed-sites'}"
            title="User allowed sites"
        />
    </section>
</template>

<script>
  import BaseReadForm from './BaseReadForm'
  import StaticFormInput from './StaticFormInput'
  import HorizontalFormField from './HorizontalFormField'
  import BaseFormButton from './BaseFormButton'
  import BaseButtonControl from './BaseButtonControl'
  import DataFormUserChangePasswordModal from './DataFormUserChangePasswordModal'
  import ChildDataList from './ChildDataList'

  export default {
    name: 'data-form-user-read',
    components:{
      BaseReadForm,
      HorizontalFormField,
      StaticFormInput,
      BaseFormButton,
      BaseButtonControl,
      DataFormUserChangePasswordModal,
      ChildDataList
    },
    data: function () {
      return {
        isChangePasswordModalActive: false
      }
    },
    methods: {
      back: function () {
        this.$refs.formComponent.back()
      },
      openDeleteModal: function () {
        this.$refs.formComponent.isDeleteModalActive=true
      },
      openChangePasswordModal: function () {
        this.isChangePasswordModalActive=true
      },
      changePassword: function (data) {
        const config = {
          method: 'post',
          url: `${this.itemUrl}/change-password`,
          data: data
        }
        this.$refs.formComponent.submitRequest(config)
      }
    }
  }
</script>