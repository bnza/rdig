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
            <v-flex xs2>
                <v-text-field readonly label="Code" :value="bucketCode"/>
            </v-flex>
            <v-flex xs2>
                <v-text-field readonly label="Type" :value="bucketType"/>
            </v-flex>
            <v-flex xs8>
                <v-text-field readonly label="Number" :value="bucket.num"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader><strong>Object</strong></v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs2>
                <v-text-field
                    readonly
                    label="Number (bucket)"
                    :value="item.num"
                    class="text-strong"
                />
            </v-flex>
            <v-flex xs2>
                <v-text-field
                    readonly
                    label="Number (site)"
                    :value="item.no"
                    class="text-strong"
                />
            </v-flex>
            <v-flex xs4 align-end>
                <v-text-field readonly label="Date of retrieval" :value="retievalDate"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs4>
                <v-text-field readonly label="Class" :value="item.class ? item.class.value : undefined"/>
            </v-flex>
            <v-flex xs4>
                <v-text-field readonly label="Type" :value="item.type ? item.type.value : undefined"/>
            </v-flex>
            <v-flex xs4>
                <v-text-field readonly label="Subtype" :value="item.subtype"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs4>
                <v-text-field readonly label="Material Class" :value="item.materialClass ? item.materialClass.value : undefined"/>
            </v-flex>
            <v-flex xs4>
                <v-text-field readonly label="Material Type" :value="item.materialType ? item.materialType.value : undefined"/>
            </v-flex>
            <v-flex xs4>
                <v-text-field readonly label="Technique" :value="item.technique ? item.technique.value : undefined"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs4>
                <v-text-field readonly label="Decoration" :value="item.decoration ? item.decoration.value : undefined"/>
            </v-flex>
            <v-flex xs4>
                <v-text-field readonly label="Color" :value="item.color ? item.color.value : undefined"/>
            </v-flex>
            <v-flex xs4>
                <v-text-field readonly label="Preservation state" :value="item.preservation ? item.preservation.value : undefined"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs3>
                <v-text-field readonly label="Height" :value="item.height"/>
            </v-flex>
            <v-flex xs3>
                <v-text-field readonly label="Length" :value="item.length"/>
            </v-flex>
            <v-flex xs3>
                <v-text-field readonly label="Width" :value="item.width"/>
            </v-flex>
            <v-flex xs3>
                <v-text-field readonly label="Thickness" :value="item.thickness"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs3>
                <v-text-field readonly label="Diameter" :value="item.diameter"/>
            </v-flex>
            <v-flex xs3>
                <v-text-field readonly label="Perforation Diameter" :value="item.perforationDiameter"/>
            </v-flex>
            <v-flex xs3>
                <v-text-field readonly label="Weight" :value="item.weight"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs4>
                <v-text-field readonly label="Coordinate N" :value="item.coordN"/>
            </v-flex>
            <v-flex xs4>
                <v-text-field readonly label="Coordinate E" :value="item.coordE"/>
            </v-flex>
            <v-flex xs4>
                <v-text-field readonly label="Coordinate Z" :value="item.coordZ"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12 md6>
                <v-text-field readonly textarea label="Description" :value="item.description"/>
            </v-flex>
            <v-flex align-start xs12 md6>
                <v-text-field readonly textarea label="Remarks" :value="item.remarks"/>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>

  export default {
    name: 'object-read-fields-item',
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
      },
      retievalDate() {
        let date = this.item && this.item.retrievalDate
        if (date) {
          date = new Date(date.date);
          return date.toLocaleDateString();
        }
      }
    }
  }
</script>

<style scoped>
    .text-strong >>> input[type="text"] {
        font-weight: bold;
    }
</style>