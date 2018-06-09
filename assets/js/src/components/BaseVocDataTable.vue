<template>
    <v-data-table
        :pagination.sync="pagination"
        :items="items"
        :headers="headers"
        :rows-per-page-items="[10, 25, 50]"
    >
        <v-progress-linear v-if="isRequestPending" slot="progress" color="blue" indeterminate></v-progress-linear>
        <template slot="items" slot-scope="props">
            <td class="justify-center layout px-0">
                <v-tooltip bottom>
                    <v-btn
                        icon
                        class="mx-0"
                        :disabled="!$store.getters['account/isAdmin']"
                        @click="$emit('update', props.item)"
                        slot="activator"
                    >
                        <v-icon color="teal">edit</v-icon>
                    </v-btn>
                    <span>Edit item</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <v-btn
                        icon
                        class="mx-0"
                        slot="activator"
                        :disabled="!$store.getters['account/isSuperUser']"
                        @click="$emit('delete', props.item)"
                    >
                        <v-icon color="pink">delete</v-icon>
                    </v-btn>
                    <span>Delete item</span>
                </v-tooltip>
            </td>
            <td
                class="text-xs-right"
            >
                {{ props.item.value }}
            </td>
        </template>
    </v-data-table>
</template>

<script>
  // import QueryMx from '../mixins/QueryMx'
  // import UuidMx from '../mixins/UuidMx'

  export default {
    name: "base-voc-data-table",
    /*mixins: [
      UuidMx,
      QueryMx,
    ],*/
    props: {
      isRequestPending: {
        type: Boolean
      },
      items: {
        type: Array
      }
    },
    data() {
      return {
        pagination: {},
        headers: [
          {
            text: '',
            value: 'id'
          },
          {text: 'Value', value: 'value'},
        ],
      }
    },
    watch: {
      pagination: {
        handler(pagination) {
          this.$emit('pagination', pagination)
        },
        deep: true
      }
    }
  }
</script>