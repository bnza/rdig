<template>
    <v-layout row wrap>
        <v-flex xs12 md10 offset-md1>
            <v-card>
                <v-card-text>
                    <v-container grid-list-xl text-xs-center>
                        <v-flex xs12>
                            <img
                                class="hidden-sm-and-down"
                                v-bind:src="rdigLogoDarkSrc" alt="rDig *dig reloaded"
                            >
                            <img
                                class="hidden-md-and-up"
                                v-bind:src="rdigLogoDarkLogoSrc" alt="rDig *dig reloaded"
                            >
                            <h1>*rDig</h1>
                            <p>The rDig project</p>
                        </v-flex>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
  export default {
    name: 'the-main-home',
    computed: {
      rdigLogoDarkSrc() {
        return require('~/assets/images/rdig_dark.png')
      },
      rdigLogoDarkLogoSrc() {
        return require('~/assets/images/rdig_logo.png')
      }
    }
  }
</script>