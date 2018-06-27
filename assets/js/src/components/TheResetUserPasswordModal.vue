<template>
    <v-dialog v-model="open" persistent max-width="600px">
        <v-card>
            <v-card-title class="red darken-2">
                <v-icon color="white">warning</v-icon>
                &nbsp;
                <span class="headline white--text">Reset password</span>
            </v-card-title>
            <v-card-text>
                <v-container
                    fluid
                    style="min-height: 0;"
                    grid-list-md
                >
                    <v-layout row wrap>
                        <p v-if="!newPassword">
                            Do you really to reset the password for user <strong>{{this.user.username}}</strong>?<br/>
                            This action <strong><span class="red--text darken-2">cannot</span></strong> be undone
                        </p>
                        <div v-else>
                            <p>
                                The new password for for user <strong>{{this.user.username}}</strong> is:<br/>
                            </p>
                            <p class="text-sm-center password"><strong>{{newPassword}}</strong></p>

                        </div>
                    </v-layout>
                </v-container>
                <v-progress-linear v-if="isRequestPending" :indeterminate="true"></v-progress-linear>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn
                    flat
                    @click="closeDialog"
                >
                    Close
                </v-btn>
                <v-btn
                    flat
                    color="red darken-2"
                    @click.native="resetPassword"
                    :disabled="isRequestPending || newPassword.length > 0"
                >
                    Reset
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
  import UuidMx from '../mixins/UuidMx'

  export default {
    name: 'the-reset-user-password-modal',
    mixins: [
      UuidMx
    ],
    props: {
      user: {
        type: Object,
        required: true
      },
      open: {
        type: Boolean,
        default: false
      }
    },
    data() {
      return {
        isRequestPending: false,
        newPassword: ''
      }
    },
    methods: {
      resetPassword() {
        const config = {
          method: 'put',
          url: `admin/user/${this.user.id}/reset-password`
        }
        this.isRequestPending = true;
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.isRequestPending = false;
            this.newPassword = response.data.password
            this.uuidMxSet('text', response.data.message, 'the-snack-bar')
            this.uuidMxSet('color', 'success', 'the-snack-bar')
            this.uuidMxSet('active', true, 'the-snack-bar')
          }
        ).catch(
          (error) => {
            this.isRequestPending = false;
            this.uuidMxSet('text', error.response.data.error, 'the-snack-bar')
            this.uuidMxSet('color', 'error', 'the-snack-bar')
            this.uuidMxSet('active', true, 'the-snack-bar')
          }
        )
      },
      closeDialog () {
        this.newPassword = ''
        this.$emit('close')
      }
    }
  }
</script>

<style scoped>
    p.password {
        margin-top: 2rem;
        margin-bottom: 2rem;
        font-family: "DejaVu Sans Mono", monospace;
    }
</style>