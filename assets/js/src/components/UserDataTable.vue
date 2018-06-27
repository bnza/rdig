<template>
    <v-data-table
        :pagination.sync="pagination"
        :headers="tableMxVisibleHeaders"
        :items="items"
        :total-items="totalItems"
        :loading="isRequestPending"
        :rows-per-page-items="[10, 25, 50]"
    >
        <template slot="no-data">
            <v-alert :value="true" outline color="info" icon="info">
                No data
            </v-alert>
        </template>
        <template slot="no-results">
            <v-alert :value="true" outline color="info" icon="info">
                No matching items found
            </v-alert>
        </template>
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
                    <span>Edit user</span>
                </v-tooltip>
                <v-btn icon class="mx-0" @click="tableMxOpenDeleteModal(props.index)">
                    <v-icon color="pink">delete</v-icon>
                </v-btn>
                <v-btn icon class="mx-0" @click="routingMxGoToItem(props.item.id)">
                    <v-icon color="blue darken-1">arrow_forward</v-icon>
                </v-btn>
            </td>
            <td class="text-xs-right">
                <strong>{{ props.item.username }}</strong>
            </td>
            <td class="text-xs-right">
                {{ props.item.roles }}
                <v-icon
                    :color="$store.getters['account/getRoleColor'](props.item.roles)"
                >
                    perm_identity
                </v-icon>
            </td>
            <td class="text-xs-right">
                <v-tooltip
                    v-if="props.item.attempts > 3"
                    top
                >
                    <span slot="activator"><v-icon color="error">warning</v-icon></span>
                    <span>Maximum login attempts exceeded</span>
                </v-tooltip>
                <v-icon v-else color="success">done</v-icon>
            </td>
        </template>
    </v-data-table>
</template>

<script>
  import BaseListDataTable from './BaseListDataTable'

  export default {
    name: 'user-data-table',
    extends: BaseListDataTable
  }
</script>
