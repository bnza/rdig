<template>
    <v-dialog v-model="open" persistent max-width="600px">
        <v-card>
            <v-card-title class="indigo darken-4">
                <v-icon color="white">save</v-icon>
                <span class="headline white--text"> Download</span>
            </v-card-title>
            <v-card-text>
                <v-container
                    fluid
                    style="min-height: 0;"
                    grid-list-md
                >
                    <v-layout
                        row
                        wrap
                        v-if="isRequestPending"
                    >
                        <!--<v-progress-linear :indeterminate="true"></v-progress-linear>-->
                    </v-layout>
                    <v-layout row wrap>
                        <v-alert outline color="indigo darken-4" :value="isRequestPending">
                            Please wait. It may takes a while <br/>
                            <v-progress-linear color="indigo darken-4" :indeterminate="true" />
                        </v-alert>
                        <p v-if="totalSelectedItem">
                            Do you really want to download the selected {{totalSelectedItem}} rows from <strong>{{this.$route.params.table}}</strong> as CSV?<br/>
                        </p>
                        <p v-else>
                            No items selected
                        </p>
                    </v-layout>
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
                    @click.native="runJob"
                    :disabled="!totalSelectedItem || isRequestPending"
                >
                    Download
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
  import fileDownload from 'js-file-download'
  import BaseFormModal from './BaseFormModal'
  import QueryMx from '../mixins/QueryMx'
  import RoutingMx from '../mixins/RoutingMx'

  export default {
    name: 'the-download-modal',
    extends: BaseFormModal,
    mixin: [
      QueryMx,
      RoutingMx
    ],
    data () {
      return {
        job: null,
        isRequestPending: false,
      }
    },
    computed: {
      totalSelectedItem () {
        return this.uuidMxGet('totalSelectedItem') || 0
      }
    },
    methods: {
      closeDialog () {
        this.uuidMxSet('totalSelectedItem', 0)
        this.$router.go(-1)
      },
      runJob () {
        let table = this.$route.params.hasOwnProperty('childTable') ? this.$route.params.childTable : this.$route.params.table
        let url = `job/csv/export/${table}/create`
        let config = {
          method: 'get',
          url: url
        }
        this.isRequestPending = true
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.job = response.data
            this.downloadCsv()
          }
        ).catch(
          (error) => {
            this.isRequestPending = false
            this.uuidMxSet('text', error.response.data, 'the-snack-bar')
            this.uuidMxSet('color', 'error', 'the-snack-bar')
            this.uuidMxSet('active', true, 'the-snack-bar')
          }
        )
      },
      downloadCsv () {
        let query = this.$route.fullPath.match(/\?(.*)$/)
        let table = this.$route.params.hasOwnProperty('childTable') ? this.$route.params.childTable : this.$route.params.table
        let url = `job/csv/export/${table}/run/${this.job.hash}?${query}`
        let config = {
          method: 'get',
          url: url
        }
        this.isRequestPending = true
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            const filename = response.headers['content-disposition'].match(/filename=\"?([\w|\.]+)/)[1]
            fileDownload(response.data, filename)
            this.isRequestPending = false
            this.closeDialog()
          }
        ).catch(
          (error) => {
            this.isRequestPending = false
            this.uuidMxSet('text', error.response.data, 'the-snack-bar')
            this.uuidMxSet('color', 'error', 'the-snack-bar')
            this.uuidMxSet('active', true, 'the-snack-bar')
          }
        )
      }
    }
  }
</script>