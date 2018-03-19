<template>
    <div>
        <v-subheader v-if="!parent__">
            <v-btn
                flat
                icon
                color="indigo darken-4"
                @click.native="toggleGroupsVisibility('site')"
            >
                <v-icon>{{getVisibilityIcon('site')}}</v-icon>
            </v-btn>
            Site
        </v-subheader>
        <div v-if="!parent__" v-show="groupsVisibility.site">
            <v-layout row wrap>
                <v-flex xs3>
                    <v-text-field color="black" class="label" value="Code" disabled/>
                </v-flex>
                <v-flex xs3>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['site.code'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs6>
                    <v-text-field label="Value" v-model="search_['site.code'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs3>
                    <v-text-field color="black" class="label" value="Name" disabled/>
                </v-flex>
                <v-flex xs3>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['site.name'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs6>
                    <v-text-field label="Value" v-model="search_['site.name'].value"/>
                </v-flex>
            </v-layout>
        </div>
        <v-subheader>
            <v-btn
                flat
                icon
                color="indigo darken-4"
                @click.native="toggleGroupsVisibility('area')"
            >
                <v-icon>{{getVisibilityIcon('area')}}</v-icon>
            </v-btn>
            Area
        </v-subheader>
        <div v-show="groupsVisibility.area">
            <v-layout row wrap>
                <v-flex xs3>
                    <v-text-field color="black" class="label" value="Code" disabled/>
                </v-flex>
                <v-flex xs3>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['area.code'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs6>
                    <v-text-field label="Value" v-model="search_['area.code'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs3>
                    <v-text-field color="black" class="label" value="Name" disabled/>
                </v-flex>
                <v-flex xs3>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['area.name'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs6>
                    <v-text-field label="Value" v-model="search_['area.name'].value"/>
                </v-flex>
            </v-layout>
        </div>
        <div v-show="groupsVisibility.context">
            <v-layout row wrap>
                <v-flex xs3>
                    <v-text-field color="black" class="label" value="Type" disabled/>
                </v-flex>
                <v-flex xs3>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_.type.op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs6>
                    <v-text-field label="Value" v-model="search_.type.value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs3>
                    <v-text-field color="black" class="label" value="Num" disabled/>
                </v-flex>
                <v-flex xs3>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.number"
                        v-model="search_.num.op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs6>
                    <v-text-field label="Value" v-model="search_.num.value"/>
                </v-flex>
            </v-layout>
        </div>
    </div>
</template>

<script>
  import BaseSearchDataForm from './BaseSearchDataForm'
  import {merge} from 'deepmerge'

  export default {
    name: 'context-search-data-form',
    extends: BaseSearchDataForm,
    data () {
      return {
        groupsVisibility: {
          site: false,
          area: false,
          context: true
        }
      }
    },
    computed: {
      defaultSearch () {
        return {
          'site.code': {},
          'site.name': {},
          'area.code': {},
          'area.name': {},
          type: {},
          num: {}
        }
      },
    }
  }
</script>