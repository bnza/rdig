<template>
    <div>
        <v-data-table
            :items="items"
            :headers="headers"
            hide-actions
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
    </div>
</template>

<script>
  export default {
    name: "base-voc-data-table",
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
        headers: [
          {
            text: '',
            value: 'id'
          },
          {text: 'Value', value: 'value'},
        ],
      }
    },
  }
</script>