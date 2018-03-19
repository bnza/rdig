<template>
    <v-dialog v-model="open" persistent max-width="600px">
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
                        ref="dataForm"
                        :prefix__="$route.params.prefix"
                        :table__="table"
                        :id__="id"
                        :parent__="parent"
                        :is="dataFormComponentName"
                        :item__="item"
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
                    color="red darken-2"
                    @click.native="$refs.dataForm.delete"
                    :disabled="isSubmitButtonDisabled"
                >
                    Delete
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
  import BaseFormModal from './BaseFormModal'

  export default {
    name: 'the-delete-modal',
    extends: BaseFormModal,
    components: {
      AreaDeleteDataForm: () => import(
        /* webpackChunkName: "AreaDeleteDataForm" */
        './AreaDeleteDataForm'
        ),
      ContextDeleteDataForm: () => import(
        /* webpackChunkName: "ContextDeleteDataForm" */
        './ContextDeleteDataForm'
        ),
      SiteDeleteDataForm: () => import(
        /* webpackChunkName: "SiteDeleteDataForm" */
        './SiteDeleteDataForm'
        ),
      UserDeleteDataForm: () => import(
        /* webpackChunkName: "UserDeleteDataForm" */
        './UserDeleteDataForm'
        ),
      UserAllowedSitesDeleteDataForm: () => import(
        /* webpackChunkName: "UserAllowedSitesDeleteDataForm" */
        './UserAllowedSitesDeleteDataForm'
        )
    },
    data () {
      return {
        componentSuffix: 'DeleteDataForm'
      }
    }
  }
</script>