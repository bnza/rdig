<template>
    <div v-if="site">
        <form>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Code</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            <input class="input is-static" type="email" v-model="site.code" readonly>
                        </p>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Name</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            <input class="input is-static" type="email" v-model="site.name" readonly>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
  export default {
    props: ['id'],
    data: function() {
      return {
        site: null
      }
    },
    created () {
      // fetch the data when the view is created and the data is
      // already being observed
      this.fetchData()
    },
    methods: {
      fetchData () {
        let config = {
          method: 'get',
          url: `data/site/${this.id}`
        }
        this.$store.dispatch('requests/perform', config)
          .then(
            (response) => {
              this.site = response.data
            }
          )
          .catch(
            this.handleErrors
          )
      }
    },
    name: "dataFormSiteRead"
  }
</script>

<style scoped>

</style>