<template>
    <v-dialog v-model="isDialogOpen" persistent max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline">Login</span>
            </v-card-title>
        </v-card>
        <v-card-text>
            <form>
                <v-text-field
                    label="Username"
                    v-model="username"
                    :error-messages="usernameErrors"
                    :counter="8"
                    @input="$v.username.$touch()"
                    @blur="$v.username.$touch()"
                    required
                />
                <v-text-field
                    label="Password"
                    v-model="password"
                    :error-messages="passwordErrors"
                    :counter="8"
                    @input="$v.password.$touch()"
                    @blur="$v.password.$touch()"
                    required
                />
            </form>
        </v-card-text>
        <v-card-actions>
            <v-spacer/>
            <v-btn color="blue darken-1" flat @click.native="isDialogOpen = false">Close</v-btn>
            <v-btn color="blue darken-1" flat @click.native="dialog = false">Save</v-btn>
        </v-card-actions>
    </v-dialog>
</template>

<script>
  import UuidMx from '../mixins/UuidMx'
  import { validationMixin } from 'vuelidate'
  import { required, minLength, email } from 'vuelidate/lib/validators'

  export default {
    name: 'the-login-modal',
    mixins: [
      UuidMx,
      validationMixin
    ],
    data: () => ({
      username: '',
      password: '',
    }),
    validations: {
      username: { required, minLength: minLength(8) },
      password: { required, minLength: minLength(8) }
    },
    computed: {
      isDialogOpen: {
        get () {
          return !!this.$_UuidMx_get('isDialogOpen')
        },
        set (value) {
          this.$_UuidMx_set('isDialogOpen', value)
        }
      },
      usernameErrors () {
        const errors = []
        if (!this.$v.username.$dirty) return errors
        !this.$v.username.maxLength && errors.push('Username must be at most 8 characters long')
        !this.$v.username.required && errors.push('Username is required.')
        return errors
      },
      passwordErrors () {
        const errors = []
        if (!this.$v.password.$dirty) return errors
        !this.$v.password.maxLength && errors.push('Password must be at most 8 characters long')
        !this.$v.password.required && errors.push('Password is required.')
        return errors
      },
    }
  }
</script>