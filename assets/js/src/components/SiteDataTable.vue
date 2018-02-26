<template>
    <base-data-table
        :items="items"
    >
        <tr slot-scope="props">
            <td class="justify-center layout px-0">
                <v-btn icon class="mx-0" @click="$_TableMx_openEditModal(props.index)">
                    <v-icon color="teal">edit</v-icon>
                </v-btn>
                <v-btn icon class="mx-0" @click="$_TableMx_openDeleteModal(props.index)">
                    <v-icon color="pink">delete</v-icon>
                </v-btn>
                <v-btn icon class="mx-0" @click="$_TableMx_goToItem(props.item.id)">
                    <v-icon color="blue darken-1">arrow_forward</v-icon>
                </v-btn>
            </td>
            <td class="text-xs-right"><strong>{{ props.item.code }}</strong></td>
            <td class="text-xs-right">{{ props.item.name }}</td>
        </tr>
    </base-data-table>
</template>

<script>
  import UuidMx from '../mixins/UuidMx'
  import RSTableMx from '../mixins/RSTableMx'
  import PathMx from '../mixins/PathMx'
  import TableMx from '../mixins/TableMx'
  import BaseDataTable from './BaseDataTable'

  export default {
    name: 'site-data-table',
    mixins: [
      UuidMx,
      PathMx,
      RSTableMx,
      TableMx
    ],
    components: {
      BaseDataTable,
    },
    data () {
      return {
        items: []
      }
    }
  }
</script>
