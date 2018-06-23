<template>
    <div>
        <v-layout row wrap>
            <v-flex xs4>
                <v-select
                    label="Operator"
                    single-line
                    bottom
                    :items="operators.text"
                    v-model="search_.code.op"
                    item-text="symbol"
                    item-value="value"
                />
            </v-flex>
            <v-flex xs8>
                <v-text-field label="Code" v-model="search_.code.value"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs4>
                <v-select
                    label="Operator"
                    single-line
                    bottom
                    :items="operators.text"
                    v-model="search_.name.op"
                    item-text="symbol"
                    item-value="value"
                />
            </v-flex>
            <v-flex xs8>
                <v-text-field label="Name" v-model="search_.name.value"/>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
  import BaseSearchDataForm from './BaseSearchDataForm'
  import {merge} from 'deepmerge'

  export default {
    name: 'site-search-data-form',
    extends: BaseSearchDataForm,
    computed: {
      defaultSearch () {
        return {
          code: {},
          name: {}
        }
      }
    }
  }
</script>