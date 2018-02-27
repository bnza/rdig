<template>
    <div
        style="max-width: 500px;"
    >
        <v-toolbar
            color="indigo darken-4"
            dark
        >
            <v-toolbar-side-icon/>
            <v-toolbar-title>
                {{$_RSTableMx_table.label}}
            </v-toolbar-title>
            <v-spacer/>
            <v-btn
                icon
                @click="$_FormMx_goToList"
            >
                <v-icon>view_comfy</v-icon>
            </v-btn>
        </v-toolbar>
        <v-card>
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
                                <small>{{$_PathMx_id}}</small>
                            </p>
                        </v-card-text>
                    </v-flex>
                </v-layout>
                <slot />
            </v-container>
        </v-card>
    </div>
</template>

<script>
  import PathMx from '../mixins/PathMx'
  import RSTableMx from '../mixins/RSTableMx'
  import UuidMx from '../mixins/UuidMx'
  import FormMx from '../mixins/FormMx'

  export default {
    name: 'data-item',
    mixins: [
      PathMx,
      RSTableMx,
      UuidMx,
      FormMx
    ]
  }
</script>