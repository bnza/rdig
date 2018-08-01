<template>
    <div>
        <data-item-card :item="item">
            <v-alert outline color="error" icon="warning" :value="item.attempts > 3">
                User exceeded the maximum login attempts number
            </v-alert>
            <user-read-fields-item :item="item"/>
        </data-item-card>
        <the-reset-user-password-modal
            v-if="item"
            :user="item"
            :open="isResetUserPasswordDialogOpen"
            @close="isResetUserPasswordDialogOpen = false"
        />
        <the-reset-login-attempts-modal
            v-if="item"
            :user="item"
            :open="isResetLoginAttemptsModalOpen"
            @close="isResetLoginAttemptsModalOpen = false"
        />
    </div>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import DataItemCard from './DataItemCard'
  import UserReadFieldsItem from './UserReadFieldsItem'
  import TheResetUserPasswordModal from './TheResetUserPasswordModal'
  import TheResetLoginAttemptsModal from './TheResetLoginAttemptsModal'

  export default {
    name: 'user-read-data-form',
    extends: BaseDataForm,
    components: {
      DataItemCard,
      UserReadFieldsItem,
      TheResetUserPasswordModal,
      TheResetLoginAttemptsModal
    },
    data() {
      return {
        prefix_: 'admin',
        isResetUserPasswordDialogOpen: false,
        isResetLoginAttemptsModalOpen: false
      }
    },
    methods: {
      openResetUserPasswordModal() {
        this.isResetUserPasswordDialogOpen = true
      },
      openResetLoginAttemptsModal() {
        this.isResetLoginAttemptsModalOpen = true
      }
    },
  }
</script>