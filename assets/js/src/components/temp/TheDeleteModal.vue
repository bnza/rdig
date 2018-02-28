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
                    <component
                        v-if="item"
                        :is="readDataComponent"
                        :item="item"
                    />
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
                    color="red darken-2"
                    @click.native="deleteItem"
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
  import FormMx from '../mixins/FormMx'
  import {pascalize} from '../util'

  export default {
    name: 'the-delete-modal',
    mixins: [
      UuidMx,
      PathMx,
      FormMx
    ],
    data () {
      return {
        idKey: 'id'
      }
    },
    components: {
      SiteDeleteFieldsItem: () => import(
        /* webpackChunkName: "SiteDeleteFieldsItem" */
        './SiteDeleteFieldsItem'
        ),
      UserAllowedSitesDeleteFieldsItem: () => import(
        /* webpackChunkName: "UserAllowedSitesDeleteFieldsItem" */
        './UserAllowedSitesDeleteFieldsItem'
        ),
      UserDeleteFieldsItem: () => import(
        /* webpackChunkName: "UserDeleteFieldsItem" */
        './UserDeleteFieldsItem'
        )
    },
    computed: {
      id () {
        return this.item ? this.item[this.idKey] : undefined
      },
      isDialogOpen: {
        get () {
          return !!this.uuidMxGet('isDialogOpen')
        },
        set (value) {
          this.uuidMxSet('isDialogOpen', value)
        }
      },
      readDataComponent: function () {
        let openerTable = this.uuidMxGet('table', this.opener)
        return `${pascalize(openerTable)}DeleteFieldsItem`
      },
      item () {
        return this.uuidMxGet('item')
      },
      opener () {
        return this.uuidMxGet('opener')
      }
    },
    methods: {
      closeDialog () {
        this.isDialogOpen = false
      },
      deleteItem () {
        this.formMxDelete().then(
          (response) => {
            this.uuidMxSet('reload', true, this.opener)
            this.closeDialog()
          }
        )
      }
    },
    watch: {
      // whenever question changes, this function will run
      isDialogOpen: function (value) {
        if (value) {
          this.pathMxTableParentD = this.uuidMxGet('parent', this.opener)
          this.pathMxTableNameD = this.uuidMxGet('table', this.opener)
          this.idKey = this.uuidMxGet('idKey', this.opener) || this.idKey
        } else {
          this.idKey = 'id'
        }
      }
    }
  }
</script>