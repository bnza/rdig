<template>
        <v-data-table
            :pagination.sync="pagination"
            :headers="rsTableMxHeaders"
            :items="items"
            :total-items="totalItems"
            :loading="isRequestPending"
            :rows-per-page-items="[10, 25, 50]"
        >
            <template slot="items" slot-scope="props">
                <td class="justify-center layout px-0">
                    <v-btn icon class="mx-0" @click="tableMxOpenEditModal(props.index)">
                        <v-icon color="teal">edit</v-icon>
                    </v-btn>
                    <v-btn icon class="mx-0" @click="tableMxOpenDeleteModal(props.index)">
                        <v-icon color="pink">delete</v-icon>
                    </v-btn>
                    <v-btn icon class="mx-0" @click="routingMxGoToItem(props.item.id)">
                        <v-icon color="blue darken-1">arrow_forward</v-icon>
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
    name: 'site-data-table',
    extends: BaseListDataTable,
  }
</script>
