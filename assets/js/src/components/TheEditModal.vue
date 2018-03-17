<template>
    <v-dialog v-model="open" persistent max-width="600px">
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
                        :prefix__="$route.params.prefix"
                        :table__="editTable"
                        :id__="editId"
                        :parent__="parent"
                        :is="dataFormComponentName"
                        :callerUuid="uuid"
                        @sync="closeDialog(true)"
                    />
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn
                    flat
                    @click="closeDialog(false)"
                >
                    Close
                </v-btn>
                <v-btn
                    flat
                    color="teal"
                    @click.native="$refs.dataForm.update"
                    :disabled="isSubmitButtonDisabled"
                >
                    Submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
  import BaseFormModal from './BaseFormModal'
  import {pascalize} from '../util'

  export default {
    name: 'the-edit-modal',
    extends: BaseFormModal,
    components: {
      AreaEditDataForm: () => import(
        /* webpackChunkName: "AreaEditDataForm" */
        './AreaEditDataForm'
        ),
      SiteEditDataForm: () => import(
        /* webpackChunkName: "SiteEditDataForm" */
        './SiteEditDataForm'
        ),
      UserEditDataForm: () => import(
        /* webpackChunkName: "UserEditDataForm" */
        './UserEditDataForm'
        )
    },
    data () {
      return {
        componentSuffix: 'EditDataForm'
      }
    },
    computed: {
      editTable () {
        return this.$route.params.childTable || this.$route.params.table
      },
      editId () {
        return this.$route.params.childId || this.$route.params.id
      },
      editDataComponent: function () {
        return `${pascalize(this.$route.params.table)}EditDataForm`
      }
    },
    created () {
      this.uuidMxSet('isInvalid', true)
    }
  }
</script>