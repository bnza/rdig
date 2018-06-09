<template>
    <article>
        <base-voc-edit-dialog
            :isRequestPending="isRequestPending"
            :open="isEditDialogOpen"
            :item="item"
            @close="closeEditDialog"
            @sync="syncItem"
        />
        <base-voc-delete-dialog
            :isRequestPending="isRequestPending"
            :open="isDeleteDialogOpen"
            :item="item"
            @close="closeDeleteDialog"
            @delete="deleteItem"
        />
        <list-voc-toolbar
            @create="openEditDialog"
        />
        <base-voc-data-table
            :isRequestPending="isRequestPending"
            :items="items"
            @delete="openDeleteDialog"
            @update="openEditDialog"
            @pagination="setPagination"
        />
    </article>
</template>

<script>
  import UuidMx from '../mixins/UuidMx'
  import QueryMx from '../mixins/QueryMx'
  import ListVocToolbar from './ListVocToolbar'
  import BaseVocDataTable from './BaseVocDataTable'
  import BaseVocDeleteDialog from './BaseVocDeleteDialog'
  import BaseVocEditDialog from './BaseVocEditDialog'

  export default {
    name: "the-voc-list",
    components: {
      ListVocToolbar,
      BaseVocDataTable,
      BaseVocDeleteDialog,
      BaseVocEditDialog
    },
    mixins: [
      QueryMx,
      UuidMx
    ],
    data () {
      return {
        isRequestPending: false,
        isDeleteDialogOpen: false,
        isEditDialogOpen: false,
        item: {},
        items: [],
        totalItems: 0
      }
    },
    computed: {
      vocabulary () {
        return this.$route.params.type  + this.$route.params.name
      }
    },
    methods: {
      fetch () {
        this.isRequestPending = true
        const config = {
          method: 'get',
          url: `voc/${this.$route.params.type}/${this.$route.params.name}?${this.fetchQuery}`
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.isRequestPending = false
            this.items = response.data
          }
        ).catch(
          (error) => {
            this.isRequestPending = false
          }
        )
      },
      setPagination (pagination) {
        this.pagination = pagination
      },
      openDeleteDialog(item) {
        this.item = item
        this.isDeleteDialogOpen = true;
      },
      closeDeleteDialog() {
        this.isDeleteDialogOpen = false;
        this.item = {}
      },
      openEditDialog(item) {
        this.item = item || {}
        this.isEditDialogOpen = true;
      },
      closeEditDialog() {
        this.isEditDialogOpen = false;
        this.item = {}
      },
      syncItem (item) {
        this.isRequestPending = true
        let method = 'post'
        let url = `voc/${this.$route.params.type}/${this.$route.params.name}`
        if (item.id) {
          method = 'put'
          url += `/${item.id}`
        }
        const config = {
          method: method,
          url: url,
          data: item
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            let action = this.item.id ? 'updated' : 'created'
            this.isRequestPending = false
            this.uuidMxSet('text', `Successfully ${action} item "${response.data.value}"`, 'the-snack-bar')
            this.uuidMxSet('color', 'success', 'the-snack-bar')
            this.uuidMxSet('active', true, 'the-snack-bar')
            this.closeEditDialog()
            this.fetch()
          }
        ).catch(
          (error) => {
            this.isRequestPending = false
            this.uuidMxSet('text', error.response.data, 'the-snack-bar')
            this.uuidMxSet('color', 'error', 'the-snack-bar')
            this.uuidMxSet('active', true, 'the-snack-bar')
          }
        )
      },
      deleteItem () {
        this.isRequestPending = true
        const config = {
          method: 'delete',
          url: `voc/${this.$route.params.type}/${this.$route.params.name}/${this.item.id}`
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.isRequestPending = false
            this.uuidMxSet('text', `Successfully deleted item "${response.data.value}"`, 'the-snack-bar')
            this.uuidMxSet('color', 'success', 'the-snack-bar')
            this.uuidMxSet('active', true, 'the-snack-bar')
            this.closeDeleteDialog()
            this.fetch()
          }
        ).catch(
          (error) => {
            this.isRequestPending = false
            this.uuidMxSet('text', error.response.data, 'the-snack-bar')
            this.uuidMxSet('color', 'error', 'the-snack-bar')
            this.uuidMxSet('active', true, 'the-snack-bar')
            this.closeDeleteDialog()
          }
        )
      }
    },
    watch: {
      vocabulary: {
        handler (value, oldValue) {
          if (value !== oldValue) {
            this.fetch()
          }
        }
      }
    }
  }
</script>

<style scoped>
    article {
        max-width: 500px;
    }
</style>