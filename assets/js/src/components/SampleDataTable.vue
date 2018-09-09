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
                        :disabled="!authMxAuthorize(getPath('update', false, props.item.id), props.item.bucket.campaign.site.id)"
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
                        :disabled="!authMxAuthorize(getPath('delete', false, props.item.id), props.item.bucket.campaign.site.id)"
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
            <td
                v-if="rsTableMxHeaderIsVisible('Field Code')"
                class="text-xs-right"
            >
                {{ getFindingFieldCode(props.item) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Reg Code')"
                class="text-xs-right"
            >
                <strong>
                    {{ getFindingRegCode(props.item) }}
                </strong>
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Site')"
                class="text-xs-right"
            >
                {{ props.item.bucket.campaign.site.code }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Year')"
                class="text-xs-right"
            >
                {{ props.item.bucket.campaign.year }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Area')"
                class="text-xs-right"
            >
                {{ props.item.bucket.context.area.code }}
            </td>
            <td
                    v-if="rsTableMxHeaderIsVisible('Bucket')"
                    class="text-xs-right"
            >
                {{ getBucketBaseCode(props.item.bucket) }}
            </td>
<!--            <td
                v-if="rsTableMxHeaderIsVisible('Group')"
                class="text-xs-right"
            >
                {{ props.item.group }}
            </td>-->
            <td
                v-if="rsTableMxHeaderIsVisible('Field no')"
                class="text-xs-right"
            >
                {{ props.item.num }}
            </td>
            <td
                    v-if="rsTableMxHeaderIsVisible('Locus Type')"
                    class="text-xs-right"
            >
                {{ props.item.bucket.context.type }}
            </td>
            <td
                    v-if="rsTableMxHeaderIsVisible('Locus Number')"
                    class="text-xs-right"
            >
                {{ props.item.bucket.context.num }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Reg no')"
                class="text-xs-right"
            >
                {{ props.item.no }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Type')"
                class="text-xs-right"
            >
                {{ getVocabularyValue(props.item.type) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Status')"
                class="text-xs-right"
            >
                {{ props.item.status }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Chronology')"
            >
                {{ getVocabularyValue(props.item.chronology) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Remarks')"
            >
                <v-tooltip
                    v-if="props.item.remarks"
                    left
                >
                    <span slot="activator">{{ trimTableCellContent(props.item.remarks) }}</span>
                    <span>{{ props.item.remarks }}</span>
                </v-tooltip>
            </td>
        </template>
    </v-data-table>
</template>

<script>
  import FindingDataTable from './FindingDataTable'

  export default {
    name: 'sample-data-table',
    extends: FindingDataTable
  }
</script>