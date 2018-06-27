<template>
    <v-card>
        <v-card-title>
            <span class="headline">Change password</span>
        </v-card-title>
        <v-card-text>
            <v-form>
                <v-layout row wrap>
                    <v-text-field
                        label="Old Password"
                        type="password"
                        v-model="oldPassword"
                        :error-messages="oldPasswordErrors"
                        :counter="8"
                        @input="formMxValidate('oldPassword')"
                        @blur="formMxValidate('oldPassword')"
                        :disabled="isRequestPending"
                        required
                    />
                </v-layout>
                <v-layout row wrap>
                    <v-text-field
                        label="Password"
                        type="password"
                        v-model="password"
                        :error-messages="passwordErrors"
                        :counter="8"
                        @input="formMxValidate('password')"
                        @blur="formMxValidate('password')"
                        :disabled="isRequestPending"
                        required
                    />
                </v-layout>
                <v-layout row wrap>
                    <v-text-field
                        label="Password (again)"
                        type="password"
                        v-model="checkPassword"
                        :error-messages="checkPasswordErrors"
                        @input="formMxValidate('checkPassword')"
                        @blur="formMxValidate('checkPassword')"
                        :disabled="isRequestPending"
                        required
                    />
                </v-layout>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-spacer/>
            <v-btn color="blue darken-1"
                   flat
                   @click.native="closeDialog"
                   :disabled="isButtonDisabled"
            >
                Cancel
            </v-btn>
            <v-btn
                flat
                color="blue darken-1"
                @click.native="submit"
                :disabled="isButtonDisabled"
            >
                Submit
            </v-btn>
        </v-card-actions>
    </v-card>

</template>

<script>
  import UuidMx from '../mixins/UuidMx'
  import FormMx from '../mixins/FormMx'
  import {validationMixin} from 'vuelidate'
  import {required, minLength, sameAs} from 'vuelidate/lib/validators'

  export default {
    name: "setting-change-password",
    props: {
      uuidMxRegister: {
        type: Boolean,
        default: true
      }
    },
    data() {
      return {
        isRequestPending: false,
        oldPassword: '',
        password: '',
        checkPassword: '',
      }
    },
    mixins: [
      validationMixin,
      UuidMx,
      FormMx
    ],
    validations: {
      oldPassword: {required, minLength: minLength(8)},
      password: {required, minLength: minLength(8)},
      checkPassword: {
        sameAsPassword: sameAs('password')
      }
    },
    methods: {
      closeDialog () {
        this.$router.go(-1)
      },
      submit () {
        const config = {
          method: 'post',
          url: `user/change-password`,
          data: {
            oldPassword: this.oldPassword,
            newPassword: this.password
          }
        }
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.uuidMxSet('text', response.data.message, 'the-snack-bar')
            this.uuidMxSet('color', 'success', 'the-snack-bar')
            this.uuidMxSet('active', true, 'the-snack-bar')
            this.$router.go(-1)
          }
        ).catch(
          (error) => {
            this.uuidMxSet('text', error.response.data.error, 'the-snack-bar')
            this.uuidMxSet('color', 'error', 'the-snack-bar')
            this.uuidMxSet('active', true, 'the-snack-bar')
          }
        )
      },
    },
    computed: {
      isButtonDisabled () {
        return this.$v.$invalid || this.isRequestPending
      },
      oldPasswordErrors() {
        const errors = []
        if (!this.$v.password.$dirty) return errors
        !this.$v.oldPassword.minLength && errors.push('Password must be almost 8 character long.')
        !this.$v.oldPassword.required && errors.push('Password is required.')
        return errors
      },
      passwordErrors() {
        const errors = []
        if (!this.$v.password.$dirty) return errors
        !this.$v.password.minLength && errors.push('Password must be almost 8 character long.')
        !this.$v.password.required && errors.push('Password is required.')
        return errors
      },
      checkPasswordErrors() {
        const errors = []
        if (!this.$v.checkPassword.$dirty) return errors
        !this.$v.checkPassword.sameAsPassword && errors.push('Passwords does not match.')
        return errors
      }
    }
  }
</script>