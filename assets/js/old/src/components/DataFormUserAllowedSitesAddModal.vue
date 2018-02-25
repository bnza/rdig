<template>
    <base-card-modal title="Grant privileges" v-bind:active="active" v-on:close="$emit('close')">
        Select a site to grant edit privileges to the selected user

        <div class="select">
            <select v-model="selected">
                <option disabled value="">Select site</option>
                <option
                    v-for="item in data"
                    v-bind:value="item.id"
                >
                    {{item.name}}
                </option>
            </select>
        </div>

        <div class="buttons" slot="footer">
            <button class="button is-text" v-on:click="$emit('close')">
                Back
            </button>
            <base-form-button
                class="is-link"
                label="Grant"
                v-bind:isRequestPending="isRequestPending"
                v-on:click="$emit('grant', selected)"
            />
        </div>
    </base-card-modal>
</template>

<script>
  import BaseCardModal from './BaseCardModal'
  import BaseFormButton from './BaseFormButton'
  import RequestHelperMixin from '../mixins/RequestHelperMixin'

  export default {
    name: 'data-form-user-allowed-sites-add-modal',
    mixins: [
      RequestHelperMixin,
    ],
    data: function () {
      return {
        data: {},
        selected: ''
      }
    },
    components: {
      BaseCardModal,
      BaseFormButton
    },
    props: {
      active: {
        type: Boolean,
        required: true
      },
      userId: {
        type: Number,
        required: true
      }
    },
    created: function () {
      let vm = this
      const config = {
        method: 'get',
        url: `admin/user/${this.userId}/user-denied-sites`
      }
      this.performRequest(config)
        .then(
          function (response) {
            vm.data = response.data
          }
        )
    }
  }
</script>

<style scoped>

</style>