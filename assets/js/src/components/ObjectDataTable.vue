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
                v-if="rsTableMxHeaderIsVisible('Code')"
                class="text-xs-right"
            >
                <strong>
                    {{ getFindingCode(props.item) }}
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
                v-if="rsTableMxHeaderIsVisible('Object no.')"
                class="text-xs-right"
            >
                {{ props.item.no }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Date of retrieval')"
            >
                {{ getDate(props.item.retrievalDate) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Class')"
            >
                {{ getVocabularyValue(props.item.class) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Type')"
            >
                {{ getVocabularyValue(props.item.type) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Sub Type')"
            >
                {{ props.item.subType }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Material Class')"
            >
                {{ getVocabularyValue(props.item.materialClass) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Material Type')"
            >
                {{ getVocabularyValue(props.item.materialType) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Technique')"
            >
                {{ getVocabularyValue(props.item.technique) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Decoration')"
            >
                {{ getVocabularyValue(props.item.decoration) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Color')"
            >
                {{ getVocabularyValue(props.item.color) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Preservation state')"
            >
                {{ getVocabularyValue(props.item.preservation) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Coord N')"
            >
                {{ props.item.coordN }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Coord E')"
            >
                {{ props.item.coordE }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Coord Z')"
            >
                {{ props.item.coordZ }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Fragments')"
            >
                {{ props.item.fragments }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Height')"
            >
                {{ props.item.height }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Length')"
            >
                {{ props.item.length }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Width')"
            >
                {{ props.item.width }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Thickness')"
            >
                {{ props.item.thickness }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Diameter')"
            >
                {{ props.item.diameter }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Perforation diameter')"
            >
                {{ props.item.perforationDiameter }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Weight')"
            >
                {{ props.item.weight }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Chronology')"
            >
                {{ getVocabularyValue(props.item.chronology) }}
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Photo')"
            >
                <v-checkbox
                    :input-value="props.item.photo"
                    :indeterminate="null === props.item.photo"
                    readonly
                    hide-details
                />
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Drawing')"
            >
                <v-checkbox
                    :input-value="props.item.drawing"
                    :indeterminate="null === props.item.drawing"
                    readonly
                    hide-details
                />
            </td>
            <td
                v-if="rsTableMxHeaderIsVisible('Year of conservation')"
            >
                {{ props.item.conservationYear }}
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
                v-if="rsTableMxHeaderIsVisible('Description')"
            >
                <v-tooltip
                    v-if="props.item.description"
                    left
                >
                    <span slot="activator">{{ trimTableCellContent(props.item.description) }}</span>
                    <span>{{ props.item.description }}</span>
                </v-tooltip>
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
    name: 'object-data-table',
    extends: FindingDataTable
  }
</script>