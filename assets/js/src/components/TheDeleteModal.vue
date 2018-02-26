<template>
    <v-dialog v-model="isDialogOpen" persistent max-width="600px">
        <v-card>
            <v-card-title class="red darken-2">
                <v-icon color="white">warning</v-icon>
                &nbsp;
                <span class="headline white--text">Delete</span>
            </v-card-title>
            <v-card-text>
                <v-container
                    fluid
                    style="min-height: 0;"
                    grid-list-md
                >
                    <v-layout row wrap>
                        <p>
                            Do you really want delete this item from table <strong>{{this.$route.params.table}}</strong>?<br/>
                            This action <strong><span class="red--text darken-2">cannot</span></strong> be undone
                        </p>
                    </v-layout>
                    <component v-if="item" :is="readDataComponent" :item="item"/>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn
                    flat
                    @click.native="closeDialog"
                >
                    Close
                </v-btn>
                <v-btn
                    flat
                    color="red darken-2" flat @click.native="deleteItem"
                >
                    Delete
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
  import PathMx from '../mixins/PathMx'
  import UuidMx from '../mixins/UuidMx'
  import {pascalize} from '../util'

  export default {
    name: 'the-delete-modal',
    mixins: [
      UuidMx,
      PathMx
    ],
    components: {
      SiteDeleteFieldsItem: () => import(
        /* webpackChunkName: "SiteDeleteFieldsItem" */
        './SiteDeleteFieldsItem'
        )
    },
    computed: {
      item () {
        return this.$_UuidMx_get('item')
      },
      id () {
        return this.item.id
      },
      isDialogOpen: {
        get () {
          return !!this.$_UuidMx_get('isDialogOpen')
        },
        set (value) {
          this.$_UuidMx_set('isDialogOpen', value)
        }
      },
      readDataComponent: function () {
        return `${pascalize(this.$route.params.table)}DeleteFieldsItem`
      }
    },
    methods: {
      closeDialog () {
        this.isDialogOpen = false
      },
      deleteItem () {
        let config = {
          method: 'delete',
          url: this.$_PathMx_itemUrl
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.item = response.data
          }
        )
      }
    }
  }
</script>