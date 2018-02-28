<template>
    <v-dialog v-model="isDialogOpen" persistent max-width="600px">
        <v-card>
            <v-card-title class="teal">
                <v-icon color="white">edit</v-icon>
                &nbsp;
                <span class="headline white--text">Edit</span>
            </v-card-title>
            <v-card-text>
                <v-container
                    fluid
                    style="min-height: 0;"
                    grid-list-md
                >
                    <component
                        ref="dataForm"
                        v-if="item"
                        :is="editDataComponent"
                        :callerUuid="uuid"
                        :item="item"
                        @input="updateItem"
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
                    color="teal"
                    @click.native="editItem"
                    :disabled="isButtonDisabled"
                >
                    Submit
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
    name: 'the-edit-modal',
    mixins: [
      UuidMx,
      PathMx,
      FormMx
    ],
    components: {
      SiteEditDataForm: () => import(
        /* webpackChunkName: "SiteEditDataForm" */
        './SiteEditDataForm'
        )
    },
    computed: {
      item: {
        get () {
          return this.uuidMxGet('item')
        },
        set (value) {
          this.uuidMxSet('item', value)
        }
      },
      id () {
        return this.item ? this.item.id : undefined
      },
      isDialogOpen: {
        get () {
          return !!this.uuidMxGet('isDialogOpen')
        },
        set (value) {
          this.uuidMxSet('isDialogOpen', value)
        }
      },
      editDataComponent: function () {
        return `${pascalize(this.$route.params.table)}EditDataForm`
      },
      isButtonDisabled () {
        //this.uuidMxGet('isInvalid')
        return  this.uuidMxGet('isInvalid') || this.$_FormMx_isRequestPending
      }
    },
    methods: {
      closeDialog () {
        this.isDialogOpen = false
      },
      updateItem(key,value) {
        let item = {}
        Object.assign(item, this.item)
        item[key] = value
        this.item = item
      },
      editItem () {
        this.formMxUpdate().then(
          (response) => {
            this.uuidMxSet('reload', true, this.uuidMxGet('opener'))
            this.closeDialog()
          }
        )
      }
    }
  }
</script>