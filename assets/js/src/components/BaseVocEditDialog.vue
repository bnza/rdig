<template>
    <v-dialog v-model="open" persistent max-width="600px">
        <v-card>
            <v-card-title v-bind:class="colorClassObject">
                <span class="headline white--text">{{editMode}}</span>
            </v-card-title>
            <v-card-text>
                <v-container
                    fluid
                    style="min-height: 0;"
                    grid-list-md
                >
                    <v-layout row wrap>
                        <v-text-field
                            label="Value"
                            type="text"
                            v-model="value"
                            :disabled="isRequestPending"
                            required
                        />
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
                    v-bind:color="color"
                    @click="$emit('sync', item_)"
                >
                    Submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
  import Vue from 'vue'

  export default {
    name: "base-voc-edit-dialog",
    data () {
      return {
        item_: {}
      }
    },
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
    },
    computed: {
      colorClassObject () {
        return {
          'indigo darken-4': !this.item.id,
          'teal': this.item.id
        }
      },
      color () {
        return this.item.id ? 'teal' : 'indigo darken-4'
      },
      editMode () {
        return this.item.id ? 'Edit' : 'New'
      },
      value: {
        get () {
          return this.item_.value
        },
        set (value) {
          Vue.set(this.item_, 'value', value)
        }
      },
    },
    watch: {
      item (newValue, oldValue) {
        this.item_ = Object.assign({}, newValue)
      }
    }
  }
</script>