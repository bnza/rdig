<template>
    <v-layout>
        <v-flex xs12 lg10 offset-lg1>
            <router-view
                class="mt-5"
            />
        </v-flex>
        <div>
            <router-view
                name="modal"
                ref="modal"
            />
        </div>
    </v-layout>
</template>

<script>
  import UuidMx from '../mixins/UuidMx'
  import {pascalize} from '../util'

  export default {
    name: 'the-main-setting',
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
    ]
  }
</script>