<template>
    <v-data-table
        :headers="rsTableMxHeaders"
        :items="items"
        :loading="isRequestPending"
        hide-actions
    >
        <template slot="items" slot-scope="props">
            <td class="justify-center layout px-0">
                <v-tooltip bottom>
                    <v-btn
                        icon
                        class="mx-0"
                        @click="tableMxOpenEditModal(props.index)"
                        slot="activator"
                    >
                        <v-icon color="teal">edit</v-icon>
                    </v-btn>
                    <span>Change password</span>
                </v-tooltip>
                <v-btn icon class="mx-0" @click="tableMxOpenDeleteModal(props.index)">
                    <v-icon color="pink">delete</v-icon>
                </v-btn>
                <v-btn icon class="mx-0" @click="tableMxGoToItem(props.item.id)">
                    <v-icon color="blue darken-1">arrow_forward</v-icon>
                </v-btn>
            </td>
            <td class="text-xs-right"><strong>{{ props.item.username }}</strong></td>
            <td class="text-xs-right">{{ props.item.roles }}</td>
        </template>
    </v-data-table>
</template>

<script>
  import BaseDataTable from './BaseDataTable'

  export default {
    name: 'user-data-table',
    extends: BaseDataTable,
    data () {
      return {
        prefix_: 'admin',
        table_: 'user'
      }
    }
  }
</script>
