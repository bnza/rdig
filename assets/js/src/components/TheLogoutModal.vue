<template>
    <v-dialog v-model="isDialogOpen" persistent max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline">Logout</span>
            </v-card-title>
            <v-card-text>
                <p>Are you sure you want to logout?</p>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn color="blue darken-1"
                       flat
                       @click.native="closeDialog"
                       :disabled="isRequestPending"
                >
                    Close
                </v-btn>
                <v-btn
                    flat
                    :disabled="isRequestPending"
                    color="blue darken-1"
                    @click.native="performLogout"
                >
                    Logout
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
  import qs from 'qs'
  import UuidMx from '../mixins/UuidMx'
  import { mapGetters } from 'vuex'
  import { validationMixin } from 'vuelidate'
  import { required, minLength } from 'vuelidate/lib/validators'

  export default {
    name: 'the-logout-modal',
    mixins: [
      UuidMx,
      validationMixin
    ],
    data () {
      return {
        from: '/'
      }
    },
    computed: {
      ...mapGetters('account', [
        'isRequestPending'
      ]),
      isDialogOpen: {
        get () {
          return !!this.uuidMxGet('isDialogOpen')
        },
        set (value) {
          this.uuidMxSet('isDialogOpen', value)
        }
      },
      isRequestPending () {
        return this.$store.state.account.requestPending
      }
    },
    methods: {
      closeDialog () {
        this.$router.replace(this.from.fullPath)
      },
      performLogout: function () {
        this.$store.dispatch('account/logout').then(
          () => {
            this.closeDialog()
          }
        )
      }
    },
    beforeRouteEnter (to, from, next) {
      next(vm => {
        vm.from = from
        vm.isDialogOpen = true
      })
    },
    beforeRouteLeave (to, from, next) {
      this.isDialogOpen = false
      next()
    }
  }
</script>