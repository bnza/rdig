<template>
    <v-container>
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
                <v-subheader><strong>Area</strong></v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs3>
                <v-text-field readonly label="Code" :value="item.code"/>
            </v-flex>
            <v-flex xs9>
                <v-text-field readonly label="Name" :value="item.name"/>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
  export default {
    name: 'area-read-fields-item',
    props: {
      item: {
        type: Object,
        required: true
      }
    },
    computed: {
      site () {
        return this.item.site || {}
      }
    }
  }
</script>