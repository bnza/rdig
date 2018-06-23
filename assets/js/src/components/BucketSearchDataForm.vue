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
                <v-flex xs4>
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
                <v-flex xs8>
                    <v-text-field label="Code" v-model="search_['site.code'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
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
                <v-flex xs8>
                    <v-text-field label="Name" v-model="search_['site.name'].value"/>
                </v-flex>
            </v-layout>
        </div>
        <v-subheader>
            <v-btn
                flat
                icon
                color="indigo darken-4"
                @click.native="toggleGroupsVisibility('campaign')"
            >
                <v-icon>{{getVisibilityIcon('campaign')}}</v-icon>
            </v-btn>
            Campaign
        </v-subheader>
        <div v-show="groupsVisibility.campaign">
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['campaign.year'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Year" v-model="search_['campaign.year'].value"/>
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
                <v-flex xs4>
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
                <v-flex xs8>
                    <v-text-field label="Code" v-model="search_['area.code'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
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
                <v-flex xs8>
                    <v-text-field label="Name" v-model="search_['area.name'].value"/>
                </v-flex>
            </v-layout>
        </div>
        <v-subheader>
            <v-btn
                flat
                icon
                color="indigo darken-4"
                @click.native="toggleGroupsVisibility('context')"
            >
                <v-icon>{{getVisibilityIcon('context')}}</v-icon>
            </v-btn>
            Context
        </v-subheader>
        <div v-show="groupsVisibility.context">
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['context.type'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Type" v-model="search_['context.type'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.number"
                        v-model="search_['context.num'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs4>
                    <v-text-field label="Number" v-model="search_['context.num'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.number"
                        v-model="search_['context.description'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Description" v-model="search_['context.description'].value"/>
                </v-flex>
            </v-layout>
        </div>
        <div v-show="groupsVisibility.bucket">
            <v-layout row wrap>
                <v-flex xs4>
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
                <v-flex xs8>
                    <v-text-field label="Number" v-model="search_.num.value"/>
                </v-flex>
            </v-layout>
        </div>
    </div>
</template>

<script>
  import BaseSearchDataForm from './BaseSearchDataForm'
  import {merge} from 'deepmerge'

  export default {
    name: 'bucket-search-data-form',
    extends: BaseSearchDataForm,
    data () {
      return {
        groupsVisibility: {
          site: false,
          area: false,
          campaign: false,
          context: false,
          bucket: true
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
          'context.type': {},
          'context.num': {},
          'context.description': {},
          'campaign.year': {},
          type: {},
          num: {}
        }
      },
    }
  }
</script>