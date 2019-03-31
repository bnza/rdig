<template>
    <v-container>
        <!--        <v-layout row wrap>
                    <v-flex align-start xs12>
                        <v-subheader>Site</v-subheader>
                    </v-flex>
                </v-layout>-->
        <v-layout row wrap>
            <v-flex xs6>
                <v-text-field readonly label="Site" :value="area.site.name"/>
            </v-flex>
            <v-flex xs6>
                <v-text-field readonly label="Area" :value="area.name"/>
            </v-flex>
        </v-layout>
        <!--<v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader>Area</v-subheader>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs3>
                <v-text-field readonly label="Code" :value="area.code"/>
            </v-flex>
            <v-flex xs9>
                <v-text-field readonly label="Name" :value="area.name"/>
            </v-flex>
        </v-layout>-->
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-subheader><strong>Identification</strong></v-subheader>
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
            <v-flex xs4>
                <v-text-field readonly label="Type" :value="type"/>
            </v-flex>
            <v-flex xs4>
                <v-text-field readonly label="Number" :value="item.num"/>
            </v-flex>
        </v-layout>
        <v-flex align-start xs12>
            <v-subheader><strong>Classification</strong></v-subheader>
        </v-flex>
        <v-layout row wrap>
            <v-flex xs6>
                <v-text-field readonly label="Chronology" :value="item.chronology ? item.chronology.value : undefined"/>
            </v-flex>
            <v-flex xs6>
                <v-text-field readonly label="Phase" :value="item.phase ? item.phase.name : undefined"/>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex align-start xs12>
                <v-textarea outline readonly label="Description" :value="item.description"/>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
  export default {
    name: 'context-read-fields-item',
    props: {
      item: {
        type: Object,
        required: true
      }
    },
    computed: {
      area() {
        return this.item.area || {site: {}}
      },
      code() {
        return this.item.area
          ? `${this.item.area.site.code}.${this.item.type}.${this.item.num}`
          : undefined
      },
      type() {
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
