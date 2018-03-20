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
                    <v-text-field
                        label="Value"
                        v-model="search_['site.code'].value"
                        mask="##"
                    />
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
            Campaign
        </v-subheader>
        <div v-show="groupsVisibility.campaign">
            <v-layout row wrap>
                <v-flex xs3>
                    <v-text-field color="black" class="label" value="Year" disabled/>
                </v-flex>
                <v-flex xs3>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.number"
                        v-model="search_.year.op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs6>
                    <v-text-field
                        label="Value"
                        v-model="search_.year.value"
                        mask="####"
                    />
                </v-flex>
            </v-layout>
        </div>
    </div>
</template>

<script>
  import BaseSearchDataForm from './BaseSearchDataForm'

  export default {
    name: 'campaign-search-data-form',
    extends: BaseSearchDataForm,
    data () {
      return {
        groupsVisibility: {
          site: false,
          campaign: true
        }
      }
    },
    computed: {
      defaultSearch () {
        return {
          'site.code': {},
          'site.name': {},
          year: {},
        }
      },
    }
  }
</script>