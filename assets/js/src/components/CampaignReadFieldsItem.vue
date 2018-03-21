<template>
    <div>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Site</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs3>
                <v-text-field readonly label="Code" :value="site.code"/>
            </v-flex>
            <v-flex xs9>
                <v-text-field readonly label="Name" :value="site.name"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader><strong>Campaign</strong></v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs3>
                <v-text-field readonly label="Campaign" :value="code"/>
            </v-flex>
            <v-flex xs9>
                <v-text-field readonly label="Year" :value="item.year"/>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
  export default {
    name: 'campaign-read-fields-item',
    props: {
      item: {
        type: Object,
        required: true
      }
    },
    computed: {
      site () {
        return this.item.site || {}
      },
      code () {
        return this.item.site ? `${this.item.site.code}.${this.item.year}` : undefined
      }
    }
  }
</script>