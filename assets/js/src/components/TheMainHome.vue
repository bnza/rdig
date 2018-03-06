<template>
    <v-container grid-list-xl text-xs-center>
        <v-layout row wrap>
            <v-flex xs10 offset-xs1>
                <v-card>
                    <v-card-text>
                        <img v-bind:src="rdigLogoDarkSrc" alt="rDig *dig reloaded">
                        <h1>*rDig</h1>
                        <p>The rDig project</p>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
  export default {
    name: 'the-main-home',
    computed: {
      rdigLogoDarkSrc() {
        return require('~/assets/images/rdig_dark.png')
      }
    }
  }
</script>