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
            Locus
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
        <v-subheader>
            <v-btn
                flat
                icon
                color="indigo darken-4"
                @click.native="toggleGroupsVisibility('inclusions')"
            >
                <v-icon>{{getVisibilityIcon('inclusions')}}</v-icon>
            </v-btn>
            Inclusions
        </v-subheader>
        <div v-show="groupsVisibility.inclusions">
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['inclusionsFrequency.value'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Inclusions Frequency" v-model="search_['inclusionsFrequency.value'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['inclusionsSize.value'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Inclusions Size" v-model="search_['inclusionsSize.value'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['inclusionsType.value'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Inclusions Type" v-model="search_['inclusionsType.value'].value"/>
                </v-flex>
            </v-layout>
        </div>
        <v-subheader>
            <v-btn
                flat
                icon
                color="indigo darken-4"
                @click.native="toggleGroupsVisibility('color')"
            >
                <v-icon>{{getVisibilityIcon('color')}}</v-icon>
            </v-btn>
            Color
        </v-subheader>
        <div v-show="groupsVisibility.color">
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['innerColor.value'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Inner Color" v-model="search_['innerColor.value'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['coreColor.value'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Core Color" v-model="search_['coreColor.value'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['outerColor.value'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Outer Color" v-model="search_['outerColor.value'].value"/>
                </v-flex>
            </v-layout>
        </div>
        <v-subheader>
            <v-btn
                flat
                icon
                color="indigo darken-4"
                @click.native="toggleGroupsVisibility('surfaceTreatment')"
            >
                <v-icon>{{getVisibilityIcon('Surface Treatment')}}</v-icon>
            </v-btn>
            Surface Treatment
        </v-subheader>
        <div v-show="groupsVisibility.surfaceTreatment">
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['innerSurfaceTreatment.value'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Inner Surface Treatment" v-model="search_['innerSurfaceTreatment.value'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['outerSurfaceTreatment.value'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Outer Surface Treatment" v-model="search_['outerSurfaceTreatment.value'].value"/>
                </v-flex>
            </v-layout>
        </div>
        <v-subheader>
            <v-btn
                flat
                icon
                color="indigo darken-4"
                @click.native="toggleGroupsVisibility('decoration')"
            >
                <v-icon>{{getVisibilityIcon('Decoration')}}</v-icon>
            </v-btn>
            Decoration
        </v-subheader>
        <div v-show="groupsVisibility.decoration">
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['innerDecoration.value'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Inner Decoration" v-model="search_['innerDecoration.value'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['outerDecoration.value'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Outer Decoration" v-model="search_['outerDecoration.value'].value"/>
                </v-flex>
            </v-layout>
        </div>
        <v-subheader>
            <v-btn
                flat
                icon
                color="indigo darken-4"
                @click.native="toggleGroupsVisibility('measure')"
            >
                <v-icon>{{getVisibilityIcon('Measure')}}</v-icon>
            </v-btn>
            Measure
        </v-subheader>
        <div v-show="groupsVisibility.measure">
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_.rimDiameter.op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Rim Diameter" v-model="search_.rimDiameter.value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_.rimWidth.op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Rim Width" v-model="search_.rimWidth.value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_.wallWidth.op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Wall Width" v-model="search_.wallWidth.value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_.maxWallDiameter.op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Max Wall Diameter" v-model="search_.maxWallDiameter.value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_.baseWidth.op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Base Width" v-model="search_.baseWidth.value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_.baseHeight.op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Base Height" v-model="search_.baseHeight.value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_.baseDiameter.op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Base Diameter" v-model="search_.baseDiameter.value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_.height.op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Height" v-model="search_.height.value"/>
                </v-flex>
            </v-layout>
        </div>
        <v-subheader>
            <v-btn
                    flat
                    icon
                    color="indigo darken-4"
                    @click.native="toggleGroupsVisibility('conservation')"
            >
                <v-icon>{{getVisibilityIcon('conservation')}}</v-icon>
            </v-btn>
            Conservation
        </v-subheader>
        <div v-show="groupsVisibility.conservation">
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                            label="Operator"
                            single-line
                            bottom
                            :items="operators.text"
                            v-model="search_.location.op"
                            item-text="symbol"
                            item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Location" v-model="search_.location.value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                            label="Operator"
                            single-line
                            bottom
                            :items="operators.boolean"
                            v-model="search_.envanterlik.op"
                            item-text="symbol"
                            item-value="value"
                    />
                </v-flex>
                <v-flex xs8 align-center>
                    <v-checkbox
                            label="Envanterlik"
                            v-model="search_.envanterlik.value"
                            hide-details
                    />
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                            label="Operator"
                            single-line
                            bottom
                            :items="operators.boolean"
                            v-model="search_.etutluk.op"
                            item-text="symbol"
                            item-value="value"
                    />
                </v-flex>
                <v-flex xs8 align-center>
                    <v-checkbox
                            label="Etutluk"
                            v-model="search_.etutluk.value"
                            hide-details
                    />
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
                        v-model="search_['class.value'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Class" v-model="search_['class.value'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['shape.value'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Shape" v-model="search_['shape.value'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['preservation.value'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Preservation" v-model="search_['preservation.value'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['technique.value'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Technique" v-model="search_['technique.value'].value"/>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_['firing.value'].op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Firing" v-model="search_['firing.value'].value"/>
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
                        :items="operators.boolean"
                        v-model="search_.restored.op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8 align-center>
                    <v-checkbox
                        label="Restored"
                        v-model="search_.restored.value"
                        hide-details
                    />
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs4>
                    <v-select
                        label="Operator"
                        single-line
                        bottom
                        :items="operators.text"
                        v-model="search_.drawingNumber.op"
                        item-text="symbol"
                        item-value="value"
                    />
                </v-flex>
                <v-flex xs8>
                    <v-text-field label="Drawing Number" v-model="search_.drawingNumber.value"/>
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
    name: 'pottery-search-data-form',
    extends: BaseSearchDataForm,
    data () {
      return {
        groupsVisibility: {
          site: false,
          area: false,
          campaign: false,
          context: false,
          bucket: false,
          inclusions: false,
          color: false,
          decoration: false,
          surfaceTreatment: false,
          measure: false,
          conservation: false,
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
          'inclusionsFrequency.value': {},
          'inclusionsSize.value': {},
          'inclusionsType.value': {},
          'coreColor.value': {},
          'innerColor.value': {},
          'outerColor.value': {},
          'class.value': {},
          'shape.value': {},
          'preservation.value': {},
          'technique.value': {},
          'firing.value': {},
          'innerSurfaceTreatment.value': {},
          'outerSurfaceTreatment.value': {},
          'innerDecoration.value': {},
          'outerDecoration.value': {},
          'chronology.value': {},
          num: {}, //num in bucket
          rimDiameter: {},
          rimWidth: {},
          wallWidth: {},
          maxWallDiameter: {},
          baseWidth: {},
          baseHeight: {},
          baseDiameter: {},
          height: {},
          remarks: {},
          location: {},
          envanterlik: {cast: 'bool'},
          etutluk: {cast: 'bool'},
          drawingNumber: {},
          restored: {cast: 'bool'}
        }
      },
    }
  }
</script>
