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
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader><strong>Sample</strong></v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs6>
                <v-text-field
                        readonly
                        label="Reg Code"
                        :value="getFindingRegCode(item)"
                        class="text-strong"
                />
            </v-flex>
            <v-flex xs6>
                <v-text-field
                        readonly
                        label="Field Code"
                        :value="getFindingFieldCode(item)"
                />
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs2>
                <v-text-field
                    readonly
                    label="Number (bucket)"
                    :value="item.num"
                />
            </v-flex>
            <v-flex xs3>
                <v-text-field readonly label="Type" :value="item.type ? item.type.value : undefined"/>
            </v-flex>
            <v-flex xs6>
                <v-text-field readonly label="Status" :value="item.status"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-textarea outline readonly label="Remarks" :value="item.remarks"/>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
  import CodeMx from '../mixins/CodeMx'

  export default {
    name: 'sample-read-fields-item',
    props: {
      item: {
        type: Object,
        required: true
      }
    },
    mixins: [
      CodeMx
    ],
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
