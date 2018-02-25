<template>
    <base-card-modal title="Change user password" v-bind:active="active" v-on:close="$emit('close')">
        <data-form-user-change-password
            v-bind:userData="userData"
            v-on:close="$emit('close')"
        />
    </base-card-modal>
</template>

<script>
  import BaseCardModal from './BaseCardModal'
  import BaseFormButton from './BaseFormButton'
  import DataFormUserChangePassword from './DataFormUserChangePassword'

  export default {
    name: 'data-form-user-change-password-modal',
    props: {
      active: {
        type: Boolean,
        required: true
      },
      userData: {
        type: Object,
        required: true
      }
    },
    components: {
      BaseCardModal,
      BaseFormButton,
      DataFormUserChangePassword
    }
  }
</script>

<style scoped>

</style>