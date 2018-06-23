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
                <v-subheader><strong>Bucket</strong></v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs4>
                <v-text-field
                    readonly
                    label="Code"
                    :value="code"
                    class="text-strong"
                />
            </v-flex>
            <!--<v-flex xs3>-->
                <!--<v-text-field readonly label="Type" :value="type"/>-->
            <!--</v-flex>-->
            <v-flex xs8>
                <v-text-field readonly label="Number" :value="item.num"/>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
  import CodeMx from '../mixins/CodeMx'

  export default {
    name: 'bucket-read-fields-item',
    mixins: [
      CodeMx,
    ],
    props: {
      item: {
        type: Object,
        required: true
      }
    },
    computed: {
      campaign () {
        return this.item.campaign || { site: {}}
      },
      context () {
        return this.item.context || { area: {}}
      },
      contextCode () {
        return this.context.type ? `${this.context.type}.${this.context.num}` : undefined
      },
      code () {
        return this.item
          ? this.getBucketCode(this.item)
          : undefined
      },
      type () {
        const type = this.item.type
          ? this.$store.getters.bucketTypeName(this.item.type)
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