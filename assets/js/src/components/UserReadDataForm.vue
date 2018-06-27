<template>
    <div>
        <data-item-card :item="item">
            <user-read-fields-item :item="item"/>
        </data-item-card>
        <the-reset-user-password-modal
            v-if="item"
            :user="item"
            :open="isResetUserPasswordDialogOpen"
            @close="isResetUserPasswordDialogOpen = false"
        />
    </div>
</template>

<script>
  import BaseDataForm from './BaseDataForm'
  import DataItemCard from './DataItemCard'
  import UserReadFieldsItem from './UserReadFieldsItem'
  import TheResetUserPasswordModal from './TheResetUserPasswordModal'

  export default {
    name: 'user-read-data-form',
    extends: BaseDataForm,
    components: {
      DataItemCard,
      UserReadFieldsItem,
      TheResetUserPasswordModal
    },
    data() {
      return {
        prefix_: 'admin',
        isResetUserPasswordDialogOpen: false
      }
    },
    methods: {
      openResetUserPasswordModal() {
        this.isResetUserPasswordDialogOpen = true
      }
    }
  }
</script>