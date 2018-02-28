<!--
    <the-main-data>
        <the-data-list> || <the-data-item> **router-view** @see js/router/index.js
    </the-main-data>
-->

<template>
    <v-container>
        <v-layout>
            <v-flex xs12 sm10 offset-xs1>
                <router-view class="mt-5" />
            </v-flex>
        </v-layout>
        <div>
            <the-add-modal />
            <the-delete-modal/>
            <the-edit-modal/>
        </div>
    </v-container>
</template>

<script>
  import UuidMx from '../mixins/UuidMx'
  import RSTableMx from '../mixins/RSTableMx'
  import TheAddModal from './TheAddModal'
  import TheDeleteModal from './TheDeleteModal'
  import TheEditModal from './TheEditModal'

  export default {
    name: 'the-main-data',
    components: {
      TheAddModal,
      TheDeleteModal,
      TheEditModal
    },
    mixins: [
      RSTableMx,
      UuidMx
    ]
  }
</script>