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
                v-if="rsTableMxHeaderIsVisible('Context')"
                class="text-xs-right"
            >
                {{ getContextCode(props.item.bucket.context) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Group')"
                class="text-xs-right"
            >
                {{ props.item.group }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Num')"
                class="text-xs-right"
            >
                {{ props.item.num }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Class')"
            >
                {{ getVocabularyValue(props.item.class) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Shape')"
            >
                {{ getVocabularyValue(props.item.shape) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Preservation')"
            >
                {{ getVocabularyValue(props.item.preservation) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Technique')"
            >
                {{ getVocabularyValue(props.item.technique) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Inclusions Type')"
            >
                {{ getVocabularyValue(props.item.inclusionsType) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Inclusions Size')"
            >
                {{ getVocabularyValue(props.item.inclusionsSize) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Inclusions Frequency')"
            >
                {{ getVocabularyValue(props.item.inclusionsFrequency) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Inner Surface Treatment')"
            >
                {{ getVocabularyValue(props.item.innerSurfaceTreatment) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Outer Surface Treatment')"
            >
                {{ getVocabularyValue(props.item.outerSurfaceTreatment) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Inner Decoration')"
            >
                {{ getVocabularyValue(props.item.innerDecoration) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Outer Decoration')"
            >
                {{ getVocabularyValue(props.item.outerDecoration) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Firing')"
            >
                {{ getVocabularyValue(props.item.firing) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Inner Color')"
            >
                {{ getVocabularyValue(props.item.innerColor) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Outer Color')"
            >
                {{ getVocabularyValue(props.item.outerColor) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Core Color')"
            >
                {{ getVocabularyValue(props.item.coreColor) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Rim Diameter')"
                class="text-xs-right"
            >
                {{ props.item.rimDiameter }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Rim Width')"
                class="text-xs-right"
            >
                {{ props.item.rimWidth }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Wall Width')"
                class="text-xs-right"
            >
                {{ props.item.wallWidth }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Max Wall Diameter')"
                class="text-xs-right"
            >
                {{ props.item.maxWallDiameter }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Base Width')"
                class="text-xs-right"
            >
                {{ props.item.baseWidth }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Base Height')"
                class="text-xs-right"
            >
                {{ props.item.baseHeight }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Base Diameter')"
                class="text-xs-right"
            >
                {{ props.item.baseDiameter }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Height')"
                class="text-xs-right"
            >
                {{ props.item.height }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Restored')"
                class="text-xs-right"
            >
                <v-checkbox
                    :input-value="props.item.restored"
                    :indeterminate="null === props.item.restored"
                    readonly
                    hide-details
                />
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Drawing Number')"
                class="text-xs-right"
            >
                {{ props.item.drawingNumber }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Location')"
            >
                {{ props.item.location }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Envanterlik')"
            >
                <v-checkbox
                    :input-value="props.item.envanterlik"
                    :indeterminate="null === props.item.envanterlik"
                    readonly
                    hide-details
                />
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Etutluk')"
            >
                <v-checkbox
                    :input-value="props.item.etutluk"
                    :indeterminate="null === props.item.etutluk"
                    readonly
                    hide-details
                />
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
    name: 'pottery-data-table',
    extends: FindingDataTable
  }
</script>