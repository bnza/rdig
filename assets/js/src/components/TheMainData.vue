<!--
    <the-main-data>
        <the-data-list> || <the-data-item> **router-view** @see js/router/index.js
    </the-main-data>
-->

<template>
    <v-container>
        <v-layout>
            <v-flex xs12 sm10 offset-xs1>
                <router-view
                    class="mt-5"
                    @listDataComponentCreated="setListDataComponentUuid"
                />
            </v-flex>
        </v-layout>
        <div>
            <router-view
                name="modal"
                ref="modal"
            />
        </div>
    </v-container>
</template>

<script>
  import UuidMx from '../mixins/UuidMx'
  import {pascalize} from '../util'

  export default {
    name: 'the-main-data',
    components: {
      TheCreateModal: () => import(
        /* webpackChunkName: "TheAddModal" */
        './TheAddModal'
        ),
      TheDeleteModal: () => import(
        /* webpackChunkName: "TheDeleteModal" */
        './TheDeleteModal'
        ),
      TheUpdateModal: () => import(
        /* webpackChunkName: "TheEditModal" */
        './TheEditModal'
        )
    },
    mixins: [
      UuidMx
    ],
    data () {
      return {
        hasModal: false
      }
    },
    computed: {
      modalComponent () {
        return `The${pascalize(this.$route.params.action)}Modal`
      }
    },
    methods: {
      /**
       * Set *-data-table uuid in 'the-main-data' namespace.
       * Only needed in page reload when no callerUuid is set for modals
       * @param uuid
       */
      setListDataComponentUuid (uuid) {
        this.uuidMxSet('listDataComponentUuid', uuid)
      }
    }
  }
</script>