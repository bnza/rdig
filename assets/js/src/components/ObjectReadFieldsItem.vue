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
                    label="Number"
                    :value="item.num"
                    class="text-strong"
                />
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
      }
    }
  }
</script>

<style scoped>
    .text-strong >>> input[type="text"] {
        font-weight: bold;
    }
</style>