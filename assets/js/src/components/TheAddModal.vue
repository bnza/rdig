<template>
    <v-dialog v-model="open" persistent max-width="600px">
        <v-card>
            <v-card-title class="indigo darken-4">
                <v-icon color="white">edit</v-icon>
                &nbsp;
                <span class="headline white--text">Add</span>
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
                        :table__="table"
                        :is="dataFormComponentName"
                        :callerUuid="uuid"
                        :parent__="parent"
                        @sync="closeDialog(true)"
                    />
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn
                    flat
                    @click.native="closeDialog(false)"
                >
                    Close
                </v-btn>
                <v-btn
                    flat
                    color="indigo darken-4"
                    @click.native="$refs.dataForm.create"
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
    name: 'the-add-modal',
    extends: BaseFormModal,
    components: {
      AreaAddDataForm: () => import(
        /* webpackChunkName: "AreaEditDataForm" */
        './AreaEditDataForm'
        ),
      ContextAddDataForm: () => import(
        /* webpackChunkName: "ContextEditDataForm" */
        './ContextEditDataForm'
        ),
      SiteAddDataForm: () => import(
        /* webpackChunkName: "SiteEditDataForm" */
        './SiteEditDataForm'
        ),
      UserAddDataForm: () => import(
        /* webpackChunkName: "UserAddDataForm" */
        './UserAddDataForm'
        ),
      UserAllowedSitesAddDataForm: () => import(
        /* webpackChunkName: "UserAllowedSitesAddDataForm" */
        './UserAllowedSitesAddDataForm'
        )
    },
    data () {
      return {
        componentSuffix: 'AddDataForm'
      }
    },
    created () {
      this.uuidMxSet('isInvalid', true)
    }
  }
</script>