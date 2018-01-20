<template>
    <div v-if="site">
        <form>
            <FormFieldHorizontal label="Code">
                <input class="input is-static" type="email" v-model="site.code" readonly>
            </FormFieldHorizontal>
            <FormFieldHorizontal label="Name">
                <input class="input is-static" type="email" v-model="site.name" readonly>
            </FormFieldHorizontal>
        </form>
    </div>
</template>

<script>
  import FormFieldHorizontal from './FormFieldHorizontal'

  export default {
    components: {
      FormFieldHorizontal
    },
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