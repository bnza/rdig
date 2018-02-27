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
                        v-if="item"
                        :is="editDataComponent"
                        $_FormMx_uuidRef="the-edit-modal"
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
          return this.$_UuidMx_get('item')
        },
        set (value) {
          this.$_UuidMx_set('item', value)
        }
      },
      id () {
        return this.item ? this.item.id : undefined
      },
      isDialogOpen: {
        get () {
          return !!this.$_UuidMx_get('isDialogOpen')
        },
        set (value) {
          this.$_UuidMx_set('isDialogOpen', value)
        }
      },
      editDataComponent: function () {
        return `${pascalize(this.$route.params.table)}EditDataForm`
      },
      isButtonDisabled () {
        //this.$_UuidMx_get('isInvalid')
        return  false || this.$_FormMx_isRequestPending
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
        this.$_FormMx_update().then(
          (response) => {
            this.$_UuidMx_set('reload', true, this.$_UuidMx_get('opener'))
            this.closeDialog()
          }
        )
      }
    }
  }
</script>