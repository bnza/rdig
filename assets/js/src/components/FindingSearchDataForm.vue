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
                    <v-text-field label="Site Code" v-model="search_['site.code'].value"/>
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
                    <v-text-field label="Site Name" v-model="search_['site.name'].value"/>
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
                    <v-text-field label="Area Code" v-model="search_['area.code'].value"/>
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
                    <v-text-field label="Area Name" v-model="search_['area.name'].value"/>
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
                    <v-text-field label="Campaign Year" v-model="search_['campaign.year'].value"/>
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
                    <v-text-field label="Context Type" v-model="search_['context.type'].value"/>
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
                <v-flex xs8>
                    <v-text-field label="Context Num" v-model="search_['context.num'].value"/>
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
                    <v-text-field label="Context Description" v-model="search_['context.description'].value"/>
                </v-flex>
            </v-layout>
        </div>
        <v-subheader>
            <v-btn
                flat
                icon
                color="indigo darken-4"
                @click.native="toggleGroupsVisibility('bucket')"
            >
                <v-icon>{{getVisibilityIcon('bucket')}}</v-icon>
            </v-btn>
            Bucket
        </v-subheader>
        <div v-show="groupsVisibility.bucket">
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['bucket.type'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Bucket Type" v-model="search_['bucket.type'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.number"
                        v-model="search_['bucket.num'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Bucket Num" v-model="search_['bucket.num'].value"/>
                </v-flex>
            </v-layout>
        </div>
        <div v-show="groupsVisibility.finding">
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_.num.op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="No. in bucket" v-model="search_.num.value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['chronology.value'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Chronology" v-model="search_['chronology.value'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_.remarks.op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Remarks" v-model="search_.remarks.value"/>
                </v-flex>
            </v-layout>
        </div>
    </div>
</template>

<script>
  import BaseSearchDataForm from './BaseSearchDataForm'

  export default {
    name: 'finding-search-data-form',
    extends: BaseSearchDataForm,
    data () {
      return {
        groupsVisibility: {
          site: false,
          area: false,
          campaign: false,
          context: false,
          bucket: false,
          finding: true
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
          'bucket.type': {},
          'bucket.num': {},
          'type.value': {},
          'chronology.value': {},
          num: {},
          remarks: {},
        }
      },
    }
  }
</script>