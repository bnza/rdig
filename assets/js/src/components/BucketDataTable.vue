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
                <v-tooltip bottom>
                    <v-btn
                        :disabled="!authMxAuthorize(getPath('update', false, props.item.id), props.item.campaign.site.id)"
                        icon
                        class="mx-0"
                        slot="activator"
                        @click="tableMxOpenEditModal(props.index)"
                    >
                        <v-icon color="teal">edit</v-icon>
                    </v-btn>
                    <span>Edit item</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <v-btn
                        :disabled="!authMxAuthorize(getPath('delete', false, props.item.id), props.item.campaign.site.id)"
                        icon
                        class="mx-0"
                        slot="activator"
                        @click="tableMxOpenDeleteModal(props.index)"
                    >
                        <v-icon color="pink">delete</v-icon>
                    </v-btn>
                    <span>Delete item</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <v-btn
                        icon
                        class="mx-0"
                        slot="activator"
                        @click="routingMxGoToItem(props.item.id)"
                    >
                        <v-icon color="blue darken-1">arrow_forward</v-icon>
                    </v-btn>
                    <span>Show item</span>
                </v-tooltip>
            </td>
            <td class="text-xs-right"><strong>{{ getCode(props.item) }}</strong></td>
            <td class="text-xs-right">{{ props.item.campaign.site.code }}</td>
            <td class="text-xs-right">{{ props.item.campaign.year }}</td>
            <td class="text-xs-right">{{ getContext(props.item) }}</td>
            <td class="text-xs-right">{{ props.item.type }}</td>
            <td class="text-xs-right">{{ props.item.num }}</td>
        </template>
    </v-data-table>
</template>

<script>
  import BaseListDataTable from './BaseListDataTable'

  export default {
    name: 'bucket-data-table',
    extends: BaseListDataTable,
    methods: {
      getCode (item) {
        return `${item.campaign.site.code}.${item.campaign.year}.${item.type}.${item.num}`
      },
      getContext (item) {
        return `${item.context.type}.${item.context.num}`
      }
    }
  }
</script>
