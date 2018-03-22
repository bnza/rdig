<template>
    <v-dialog v-model="isDialogOpen" persistent max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline">Login</span>
            </v-card-title>
            <v-card-text>
                <v-alert outline color="error" icon="warning" :value="hasMessage">
                    {{message}}
                </v-alert>
                <v-form>
                    <v-text-field
                        label="Username"
                        v-model="username"
                        :error-messages="usernameErrors"
                        @input="$v.username.$touch()"
                        @blur="$v.username.$touch()"
                        :disabled="isRequestPending"
                        required
                    />
                    <v-text-field
                        label="Password"
                        type="password"
                        v-model="password"
                        :error-messages="passwordErrors"
                        @input="$v.password.$touch()"
                        @blur="$v.password.$touch()"
                        :disabled="isRequestPending"
                        required
                    />
                </v-form>
                <v-progress-linear
                    :indeterminate="true"
                    v-if="isRequestPending"
                />
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
                    :disabled="$v.$invalid || isRequestPending"
                    color="blue darken-1"
                    @click.native="performLogin"
                >
                    Submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
  import qs from 'qs'
  import UuidMx from '../mixins/UuidMx'
  import AuthMx from '../mixins/AuthMx'
  import { mapGetters } from 'vuex'
  import { validationMixin } from 'vuelidate'
  import { required } from 'vuelidate/lib/validators'

  export default {
    name: 'the-login-modal',
    mixins: [
      UuidMx,
      AuthMx,
      validationMixin
    ],
    data: () => ({
      from: '',
      username: '',
      password: '',
      message: ''
    }),
    validations: {
      username: { required },
      password: { required }
    },
    computed: {
      ...mapGetters('account', [
        'isRequestPending'
      ]),
      hasMessage () {
        return !!this.message
      },
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
      },
      passwordErrors () {
        const errors = []
        if (!this.$v.password.$dirty) return errors
        !this.$v.password.required && errors.push('Password is required.')
        return errors
      },
      usernameErrors () {
        const errors = []
        if (!this.$v.username.$dirty) return errors
        !this.$v.username.required && errors.push('Username is required.')
        return errors
      }
    },
    methods: {
      closeDialog () {
        const to = this.authMxAuthorize(this.from) ? this.from : '/'
        this.$router.replace(to)
      },
      performLogin: function () {
        const credentials = qs.stringify({
          username: this.username,
          password: this.password
        })
        this.$store.dispatch('account/login', credentials).then(
          () => {
            this.closeDialog()
          }
        ).catch(
          (error) => {
            this.message = error.response.data
          }
        )
      }
    },
    beforeRouteEnter (to, from, next) {
      next(vm => {
        vm.isDialogOpen = true
        vm.from = from.fullPath
      })
    },
    beforeRouteLeave (to, from, next) {
      this.isDialogOpen = false
      next()
    },
  }
</script>