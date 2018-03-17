<template>
    <v-dialog v-model="open" persistent max-width="600px">
        <v-card>
            <v-card-title class="indigo darken-4">
                <v-icon color="white">search</v-icon>
                &nbsp;
                <span class="headline white--text">Search</span>
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
                        :searchCriteria__="searchCriteria"
                        @sync="sync"
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
                    color="indigo darken-4"
                    @click.native="dataFormComponent.clear"
                >
                    Clear
                </v-btn>
                <v-btn
                    flat
                    color="indigo darken-4"
                    @click.native="executeSearch"
                >
                    Search
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
  import BaseFormModal from './BaseFormModal'

  export default {
    name: 'the-search-modal',
    extends: BaseFormModal,
    components: {
      AreaSearchDataForm: () => import(
        /* webpackChunkName: "AreaSearchDataForm" */
        './AreaSearchDataForm'
        ),
      SiteSearchDataForm: () => import(
        /* webpackChunkName: "SiteSearchDataForm" */
        './SiteSearchDataForm'
        ),
      UserAllowedSitesSearchDataForm: () => import(
        /* webpackChunkName: "UserAllowedSitesSearchDataForm" */
        './UserAllowedSitesSearchDataForm'
        ),
      UserSearchDataForm: () => import(
        /* webpackChunkName: "UserSearchDataForm" */
        './UserSearchDataForm'
        )
    },
    data () {
      return {
        componentSuffix: 'SearchDataForm',
        uncommittedSearchCriteria: false
      }
    },
    computed: {
      searchCriteria: {
        get () {
          let criteria = this.uuidMxGet('searchCriteria', this.callerUuid)
          if (criteria) {
            return JSON.parse(JSON.stringify(criteria))
          }
        },
        set (value) {
          this.uuidMxSet('searchCriteria', value, this.callerUuid)
        }
      }
    },
    methods: {
      sync (value) {
        this.uncommittedSearchCriteria = value
      },
      executeSearch () {
        this.searchCriteria = this.uncommittedSearchCriteria
          ? JSON.parse(JSON.stringify(this.uncommittedSearchCriteria))
          : undefined
        this.closeDialog(false)
      }
    }
  }
</script>