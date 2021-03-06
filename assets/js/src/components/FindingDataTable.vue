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
                        :disabled="!authMxAuthorize(getSpecPath('update', false, props.item), props.item.bucket.campaign.site.id)"
                        icon
                        class="mx-0"
                        slot="activator"
                        @click="tableMxOpenEditModal(props.index, undefined, {finding: specs[props.item.group]})"
                    >
                        <v-icon color="teal">edit</v-icon>
                    </v-btn>
                    <span>Edit item</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <v-btn
                        :disabled="!authMxAuthorize(getSpecPath('delete', false, props.item), props.item.bucket.campaign.site.id)"
                        icon
                        class="mx-0"
                        slot="activator"
                        @click="tableMxOpenDeleteModal(props.index, undefined, {finding: specs[props.item.group]})"
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
                        @click="goToSpecItem(props.item)"
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
            <td
                v-if="rsTableMxHeaderIsVisible('Group')"
                class="text-xs-right"
            >
                {{ props.item.group }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Letter/Number in Bucket')"
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
  import BaseListDataTable from './BaseListDataTable'

  export default {
    name: 'finding-data-table',
    extends: BaseListDataTable,
    data() {
      return {
        specs: {
          O: 'object',
          P: 'pottery',
          S: 'sample'
        }
      }
    },
    methods: {
      replacePathSpec(path, group) {
        return path.replace(/finding/, this.specs[group])
      },
      getSpecPath(action, list, item) {
        let path = this.getPath(action, list, item.id);
        return this.replacePathSpec(path, item.group)
      },
      goToSpecItem(item) {
        let path = this.replacePathSpec(this.routingMxGetItemPath(item.id), item.group)
        this.$router.push(path)
      },
      openDownloadModal() {
        this.uuidMxSet('totalSelectedItem', this.totalItems, 'the-download-modal')
        //let path = `/data/${this.$route.params.table}/download`
        let path = `${this.routingMxBasePath}/download`
        this.$router.push(path)
      }
    }
  }
</script>