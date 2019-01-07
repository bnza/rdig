<template>
    <v-container>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Site</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs2>
                <v-text-field readonly label="Site (code)" :value="campaign.site.code"/>
            </v-flex>
            <v-flex xs8>
                <v-text-field readonly label="Site (name)" :value="campaign.site.name"/>
            </v-flex>
            <v-flex xs2>
                <v-text-field readonly label="Campaign" :value="campaign.year"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Context</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs2>
                <v-text-field readonly label="Area (code)" :value="context.area.code"/>
            </v-flex>
            <v-flex xs8>
                <v-text-field readonly label="Area (name)" :value="context.area.name"/>
            </v-flex>
            <v-flex xs2>
                <v-text-field readonly label="Context" :value="contextCode"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Bucket</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12>
                <v-text-field
                        readonly
                        label="Code"
                        :value="getBucketCode(item.bucket)"
                />
            </v-flex>
<!--            <v-flex xs2>
                <v-text-field readonly label="Code" :value="bucketCode"/>
            </v-flex>
            <v-flex xs2>
                <v-text-field readonly label="Type" :value="bucketType"/>
            </v-flex>
            <v-flex xs8>
                <v-text-field readonly label="Number" :value="bucket.num"/>
            </v-flex>-->
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader><strong>Pottery</strong></v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
<!--            <v-flex xs5>
                <v-text-field
                    readonly
                    label="Reg Code"
                    :value="getFindingRegCode(item)"
                    class="text-strong"
                />
            </v-flex>-->
            <v-flex xs9>
                <v-text-field
                    readonly
                    label="Field Code"
                    :value="getFindingFieldCode(item)"
                    class="text-strong"
                />
            </v-flex>
            <v-flex xs3>
                <v-text-field
                    readonly
                    label="Number"
                    :value="item.num"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6 md3>
                <v-text-field readonly label="Class" :value="item.class ? item.class.value : undefined"/>
            </v-flex>
            <v-flex xs6 md3>
                <v-text-field readonly label="Shape" :value="item.shape ? item.shape.value : undefined"/>
            </v-flex>
            <v-flex xs6 md3>
                <v-text-field readonly label="Technique" :value="item.technique ? item.technique.value : undefined"/>
            </v-flex>
            <v-flex xs6 md3>
                <v-text-field readonly label="Firing" :value="item.firing ? item.firing.value : undefined"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs4>
                <v-text-field readonly label="Inclusions (type)" :value="item.inclusionsType ? item.inclusionsType.value : undefined"/>
            </v-flex>
            <v-flex xs4>
                <v-text-field readonly label="Inclusions (size)" :value="item.inclusionsSize ? item.inclusionsSize.value : undefined"/>
            </v-flex>
            <v-flex xs4>
                <v-text-field readonly label="Inclusions (freq)" :value="item.inclusionsFrequency ? item.inclusionsFrequency.value : undefined"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-text-field readonly label="Inner Surface Treatment" :value="item.innerSurfaceTreatment ? item.innerSurfaceTreatment.value : undefined"/>
            </v-flex>
            <v-flex xs6>
                <v-text-field readonly label="Outer Surface Treatment" :value="item.outerSurfaceTreatment ? item.outerSurfaceTreatment.value : undefined"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-text-field readonly label="Inner Decoration" :value="item.innerDecoration ? item.innerDecoration.value : undefined"/>
            </v-flex>
            <v-flex xs6>
                <v-text-field readonly label="Outer Decoration" :value="item.outerDecoration ? item.outerDecoration.value : undefined"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs4>
                <v-text-field readonly label="Inner Color" :value="item.innerColor ? item.innerColor.value : undefined"/>
            </v-flex>
            <v-flex xs4>
                <v-text-field readonly label="Outer Color" :value="item.outerColor ? item.outerColor.value : undefined"/>
            </v-flex>
            <v-flex xs4>
                <v-text-field readonly label="Core Color" :value="item.coreColor ? item.coreColor.value : undefined"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6 md3>
                <v-text-field readonly label="Rim Diameter" :value="item.rimDiameter"/>
            </v-flex>
            <v-flex xs6 md3>
                <v-text-field readonly label="Rim Width" :value="item.rimWidth"/>
            </v-flex>
            <v-flex xs6 md3>
                <v-text-field readonly label="Wall Width" :value="item.wallWidth"/>
            </v-flex>
            <v-flex xs6 md3>
                <v-text-field readonly label="Max Wall Diameter" :value="item.maxWallDiameter"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6 md3>
                <v-text-field readonly label="Base Width" :value="item.baseWidth"/>
            </v-flex>
            <v-flex xs6 md3>
                <v-text-field readonly label="Base Height" :value="item.baseHeight"/>
            </v-flex>
            <v-flex xs6 md3>
                <v-text-field readonly label="Base Diameter" :value="item.baseDiameter"/>
            </v-flex>
            <v-flex xs6 md3>
                <v-text-field readonly label="Height" :value="item.height"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Conservation</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs4>
                <v-text-field readonly label="Location" :value="item.location"/>
            </v-flex>
            <v-flex xs4>
                <v-checkbox readonly label="Envanterlik" :input-value="item.envanterlik" :indeterminate="null === item.etutluk"/>
            </v-flex>
            <v-flex xs4>
                <v-checkbox readonly label="Etutluk" :input-value="item.etutluk" :indeterminate="null === item.etutluk"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-text-field readonly textarea label="Remarks" :value="item.remarks"/>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
  import CodeMx from '../mixins/CodeMx'
  export default {
    name: 'sample-read-fields-item',
    mixins: [
      CodeMx
    ],
    props: {
      item: {
        type: Object,
        required: true
      }
    },
    computed: {
      bucket () {
        return this.item.bucket || { site: {}}
      },
      campaign () {
        return this.item.bucket && this.item.bucket.campaign || { site: {}}
      },
      context () {
        return this.item.bucket && this.item.bucket.context || { area: {}}
      },
      contextCode () {
        return this.context.type ? `${this.context.type}.${this.context.num}` : undefined
      },
      bucketCode () {
        return this.item && this.item.hasOwnProperty('bucket')
          ? `${this.item.bucket.type}.${this.item.bucket.num}`
          : undefined
      },
      bucketType () {
        const type = this.item && this.item.bucket
          ? this.$store.getters.bucketTypeName(this.item.bucket.type)
          : undefined
        return type ? type.name : undefined
      }
    }
  }
</script>

<style scoped>
    .text-strong >>> input[type="text"] {
        font-weight: bold;
    }
</style>
