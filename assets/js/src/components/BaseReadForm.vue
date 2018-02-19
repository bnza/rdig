<template>
    <form v-if="hasData">
        <header>
            <slot name="header" />
            <slot name="modals">
                <section>
                    <slot name="modal-delete">
                        <data-form-delete-modal
                            v-on:delete="deleteEntity"
                            v-on:close="isDeleteModalActive=false"
                            v-bind:table="$_route.table"
                            v-bind:active="isDeleteModalActive"
                            v-bind:isRequestPending="isRequestPending"
                        >
                        </data-form-delete-modal>
                    </slot>
                    <slot name="other-modals"
                          v-bind:data="data"
                          v-bind:hasData="hasData"
                    />
                </section>
            </slot>
        </header>
        <main>
            <slot
                v-bind:data="data"
                v-bind:hasData="hasData"
                v-bind:violations="violations"
            />
        </main>
        <footer>
            <slot name="footer"
                  v-bind:hasData="hasData"
            >
                <horizontal-read-form-field-button-group
                    v-on:back="back"
                    v-on:edit="edit"
                    v-on:delete="isDeleteModalActive=true"
                />
            </slot>
        </footer>
    </form>
    <article v-else>
        <p v-if="isRequestPending">Loading</p>
        <p v-else>Nothing found</p>
    </article>

</template>

<script>
  import BaseForm from './BaseForm'
  import HorizontalReadFormFieldButtonGroup from './HorizontalReadFormFieldButtonGroup'
  import DataFormDeleteModal from './DataFormDeleteModal'

  export default {
    name: "base-read-form",
    extends: BaseForm,
    components: {
      HorizontalReadFormFieldButtonGroup,
      DataFormDeleteModal
    },
    methods: {
      back: function () {
        this.$router.push(this.listPath)
      },
      edit: function () {
        this.$router.push(this.updatePath)
      },
      deleteEntity: function () {
        const config = {
          method: 'delete',
          url: this.itemUrl
        }
        this.submitRequest(config)
      }
    }
  }
</script>