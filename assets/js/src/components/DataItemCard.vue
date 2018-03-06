<template>
    <v-card flat>
        <v-container
            fluid
            style="min-height: 0;"
            grid-list-md
        >
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card-text>
                        <p
                            class="text-xs-right"
                            color="grey lighten-3"
                        >
                            <small>{{id}}</small>
                        </p>
                    </v-card-text>
                </v-flex>
            </v-layout>
            <slot />
        </v-container>
    </v-card>
</template>

<script>
  export default {
    name: 'data-item-card',
    props: {
      item: {
        type: Object,
        required: true
      }
    },
    computed: {
      id () {
        return this.item.id || ''
      }
    }
  }
</script>