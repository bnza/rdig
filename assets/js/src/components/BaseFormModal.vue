<!--
<template>
    <v-dialog v-model="isDialogOpen">       #isDialogOpen hide/show dialog
        <component                          #form component
            ref="dataForm"
            :is="*DataComponent"
            :pathMxItemIdP="id"
            :callerUuid="uuid"
            @updated="closeDialog(true)"
         />
    </v-dialog>
-->

<script>
  import PathMx from '../mixins/PathMx'
  import UuidMx from '../mixins/UuidMx'
  import {pascalize} from '../util'

  export default {
    name: 'base-form-modal',
    mixins: [
      UuidMx,
      PathMx
    ],
    computed: {
      dataFormComponent () {
        return this.table ? `${pascalize(this.table)}${this.componentSuffix}` : ''
      },
      id () {
        return this.item ? this.item.id : undefined
      },
      isDialogOpen: {
        get () {
          return !!this.uuidMxGet('isDialogOpen')
        },
        set (value) {
          this.uuidMxSet('isDialogOpen', value)
        }
      },
      isSubmitButtonDisabled () {
        if (this.uuidMxGet('isInvalid')) {
          return true
        }
        return this.$refs.dataForm ? this.$refs.dataForm.isRequestPending : false
      },
      item () {
        return this.uuidMxGet('item')
      },
      table () {
        return this.uuidMxGet('table')  // || this.$route.params.table
      },
      parent () {
        return this.uuidMxGet('parent')
      }
    },
    methods: {
      closeDialog (reloadList) {
        this.isDialogOpen = false
        this.uuidMxSet('table', '')
        this.$refs.dataForm.item = {}
        if (reloadList) {
          this.uuidMxSet('reload', true, this.uuidMxGet('opener'))
        }
      }
    }
  }
</script>