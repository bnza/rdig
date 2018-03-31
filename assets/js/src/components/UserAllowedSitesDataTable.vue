<template>
    <v-data-table
        :pagination.sync="pagination"
        :headers="tableMxVisibleHeaders"
        :items="items"
        :total-items="totalItems"
        :loading="isRequestPending"
        :rows-per-page-items="[10, 25, 50]"
    >
        <template slot="items" slot-scope="props">
            <td class="justify-center layout px-0">
                <v-btn icon class="mx-0" @click="tableMxOpenDeleteModal(props.index)">
                    <v-icon color="pink">delete</v-icon>
                </v-btn>
            </td>
            <td class="text-xs-right"><strong>{{ props.item.code }}</strong></td>
            <td class="text-xs-right">{{ props.item.name }}</td>
        </template>
    </v-data-table>
</template>

<script>
  import BaseListDataTable from './BaseListDataTable'

  export default {
    name: 'user-allowed-sites-data-table',
    extends: BaseListDataTable,
    data () {
      return {
        prefix_: 'admin',
        table_: 'user-allowed-sites',
      }
    },
    created () {
      if (this.uuid) {
        this.uuidMxSet('idKey', 'siteId')
      }
    }
  }
</script>
