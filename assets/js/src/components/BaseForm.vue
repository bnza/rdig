<template>
    <form>
        <header>
            <slot name="header" />
            <slot name="modals" />
        </header>
        <main>
            <slot
                v-bind:data="data"
                v-bind:violations="violations"
                v-bind:isRequestPending="isRequestPending"
            />
        </main>
        <footer>
            <slot name="footer" />
        </footer>
    </form>
</template>

<script>
  import {mapGetters} from 'vuex'
  import PathHelperMixin from '../mixins/PathHelperMixin'
  import DataFormMixin from '../mixins/DataFormMixin'

  export default {
    name: "base-form",
    components: {
      BaseFormField: () => import(
        /* webpackChunkName: "BaseFormField" */
        './BaseFormField'
        ),
    },
    mixins: [
      PathHelperMixin,
      DataFormMixin
    ],
    props: {
      fetch: {
        type: Boolean,
        default: true
      }
    },
    data: function () {
      return {
        uuid: false,
        isDeleteModalActive: false
      }
    },
    methods: {
      updateValue: function (fieldKey, value) {
        this.data[fieldKey] = value
      },
      fieldComponent: function (fieldKey) {
        return this._fieldComponentGetterFn(this.uuid,fieldKey)
      },
      setUp: function () {
        this.$store.dispatch('components/forms/setConfig', {
          config: this.formConfigObject,
          uuid: this.uuid
        })
      }
    },
    computed: {
      ...mapGetters('components/forms', {
        _fieldsGetterFn: 'fields',
        _fieldComponentGetterFn: 'fieldComponentFn'
      }),
      classObject: function () {
        return {}
      },
      fields: function () {
        return this._fieldsGetterFn(this.uuid)
      },
      hasData: function () {
        return this.data !== {}
      }
    },
    created: function () {
      let vm = this
      this.$store.dispatch('components/forms/add').then(
        function (uuid) {
          vm.uuid = uuid
          //vm.setUp()
          vm.readData()
        }
      )
    },
    beforeDestroy: function () {
      this.$store.dispatch('components/forms/remove', this.uuid)
    }
  }
</script>

<style scoped>
    footer {
        margin-top: 3rem;
    }
</style>