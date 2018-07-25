<template>
    <v-card>
        <v-card-title>
            <span class="headline">Filter site</span>
        </v-card-title>
        <v-card-text>
            <v-form>
                <v-select
                    label="Select site"
                    single-line
                    bottom
                    :items="sites"
                    v-model="siteCode"
                    item-text="name"
                    item-value="code"
                />
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-spacer/>
            <v-btn color="blue darken-1"
                   flat
                   @click.native="closeDialog"
            >
                Cancel
            </v-btn>
            <v-btn
                flat
                color="blue darken-1"
                @click.native="setFilter"
                :disabled="!siteCode"
            >
                Select
            </v-btn>
            <v-btn
                flat
                color="blue darken-1"
                @click.native="resetFilter"
            >
                Reset
            </v-btn>
        </v-card-actions>
    </v-card>

</template>

<script>
  import UuidMx from '../mixins/UuidMx'

  export default {
    name: "setting-site-filter",
    data() {
      return {
        sites: [],
        siteCode: null
      }
    },
    mixins: [
      UuidMx
    ],
    methods: {
      fetchSites () {
        const config = {
          method: 'get',
          url: `fsc/sites`
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.sites = response.data
          }
        )
      },
      closeDialog () {
        this.$router.go(-1)
      },
      setFilter () {
        const config = {
          method: 'get',
          url: `fsc/${this.siteCode}/0`
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.$store.commit('SET_SITE_FILTER', response.data)
            this.uuidMxSet('text', `Successfully set site filter to ${response.data.name}`, 'the-snack-bar')
            this.uuidMxSet('color', 'success', 'the-snack-bar')
            this.uuidMxSet('active', true, 'the-snack-bar')
            this.$router.go(-1)
          }
        )
      },
      resetFilter () {
        const config = {
          method: 'get',
          url: `fsc/reset/0`
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            document.title = 'rDig - *Dig reloaded'
            this.$store.commit('SET_SITE_FILTER', null)
            this.uuidMxSet('text', `Successfully reset site filter`, 'the-snack-bar')
            this.uuidMxSet('color', 'success', 'the-snack-bar')
            this.uuidMxSet('active', true, 'the-snack-bar')
            this.$router.go(-1)
          }
        )
      }
    },
    created() {
      this.fetchSites()
    }
  }
</script>