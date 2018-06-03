<template>
    <v-dialog v-model="open" persistent max-width="600px">
        <v-card>
            <v-card-title class="red darken-2">
                <v-icon color="white">warning</v-icon>
                <span class="headline white--text">Delete</span>
            </v-card-title>
            <v-card-text>
                <v-container
                    fluid
                    style="min-height: 0;"
                    grid-list-md
                >
                    <v-layout row wrap>
                        <h3 class="text-xs-center">{{item.value}}</h3>
                    </v-layout>
                    <v-layout row wrap>
                        <p>
                            Do you really want delete this item?<br/>
                            This action will affect every finding referencing it and  <strong><span class="red--text darken-2">cannot</span></strong> be undone
                        </p>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn
                    flat
                    @click="$emit('close')"
                >
                    Close
                </v-btn>
                <v-btn
                    flat
                    color="red darken-2"
                    @click="$emit('delete')"
                >
                    Delete
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
  export default {
    name: "base-voc-delete-dialog",
    props: {
      isRequestPending: {
        type: Boolean,
        required: true
      },
      open: {
        type: Boolean,
        default: false
      },
      item: {
        type: Object,
        required: true
      }
    }
  }
</script>

<style scoped>
    h3 {
        font-family: "DejaVu Sans Mono", monospace;
    }
</style>