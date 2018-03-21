<template>
    <v-container>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Site</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs3>
                <v-text-field readonly label="Site" :value="campaign.site.code"/>
            </v-flex>
            <v-flex xs9>
                <v-text-field readonly label="Year" :value="campaign.site.name"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Context</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs3>
                <v-text-field readonly label="Area" :value="context.area.code"/>
            </v-flex>
            <v-flex xs9>
                <v-text-field readonly label="Context" :value="contextCode"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader><strong>Bucket</strong></v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs3>
                <v-text-field
                    readonly
                    label="Code"
                    :value="code"
                    class="text-strong"
                />
            </v-flex>
            <v-flex xs3>
                <v-text-field readonly label="Type" :value="type"/>
            </v-flex>
            <v-flex xs6>
                <v-text-field readonly label="Number" :value="item.num"/>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
  export default {
    name: 'bucket-read-fields-item',
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
          ? `${this.item.type}.${this.item.num}`
          : undefined
      },
      type () {
        const type = this.$store.getters.contextTypeName(this.item.type)
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