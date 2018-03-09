<template>
    <div>
        <v-layout row wrap>
            <v-flex xs3>
                <v-text-field color="black" class="label" value="Username" disabled/>
            </v-flex>
            <v-flex xs3>
                <v-select
                    label="Operator"
                    single-line
                    bottom
                    :items="operators.text"
                    v-model="search_.username.op"
                    item-text="symbol"
                    item-value="value"
                />
            </v-flex>
            <v-flex xs6>
                <v-text-field label="Value" v-model="search_.username.value"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs3>
                <v-text-field color="black" class="label" value="Roles" disabled/>
            </v-flex>
            <v-flex xs3>
                <v-select
                    label="Operator"
                    single-line
                    bottom
                    :items="operators.text"
                    v-model="search_.roles.op"
                    item-text="symbol"
                    item-value="value"
                />
            </v-flex>
            <v-flex xs6>
                <v-text-field label="Value" v-model="search_.roles.value"/>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
  import BaseSearchDataForm from './BaseSearchDataForm'
  import {merge} from 'deepmerge'

  export default {
    name: 'user-search-data-form',
    extends: BaseSearchDataForm,
    computed: {
      defaultSearch () {
        return {
          username: {},
          roles: {}
        }
      }
    }
  }
</script>