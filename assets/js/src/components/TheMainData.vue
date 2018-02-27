<template>
    <v-container>
        <v-layout>
            <v-flex xs12 sm10 offset-xs1>
                <router-view class="mt-5"/>
            </v-flex>
        </v-layout>
        <div>
            <the-delete-modal/>
            <the-edit-modal/>
        </div>
    </v-container>
</template>

<script>
  import UuidMx from '../mixins/UuidMx'
  import RSTableMx from '../mixins/RSTableMx'
  import TheDeleteModal from './TheDeleteModal'
  import TheEditModal from './TheEditModal'

  export default {
    name: 'the-main-data',
    components: {
      TheDeleteModal,
      TheEditModal
    },
    mixins: [
      RSTableMx,
      UuidMx
    ]
  }
</script>