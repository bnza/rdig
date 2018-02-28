<template>
    <v-data-table
        :headers="rsTableMxHeaders"
        :items="items"
        :loading="isRequestPending"
        v-bind:pathMxTableNameP="table"
        hide-actions
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
  import BaseDataTable from './BaseDataTable'

  export default {
    name: 'user-allowed-sites-data-table',
    extends: BaseDataTable,
    data () {
      return {
        prefix_: 'admin',
        table_: 'user-allowed-sites',
      }
    },
    created () {
      if (this.pathMxTableParentP && this.uuid) {
        this.uuidMxSet('idKey', 'siteId')
      }
    }
  }
</script>
