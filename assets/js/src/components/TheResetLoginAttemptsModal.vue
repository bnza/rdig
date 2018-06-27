<template>
    <v-dialog v-model="open" persistent max-width="600px">
        <v-card>
            <v-card-title class="indigo darken-4">
                <span class="headline white--text">Reset login attempts</span>
            </v-card-title>
            <v-card-text>
                <v-container
                    fluid
                    style="min-height: 0;"
                    grid-list-md
                >
                    <v-layout row wrap>
                        <p>
                            This action will reset the login attempts number of user <strong>{{this.user.username}}</strong>.<br/>
                            Would you like to proceed?<br/>
                        </p>
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
                    color="indigo darken-4"
                    @click.native="resetPassword"
                    :disabled="isRequestPending"
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
    name: 'the-reset-login-attempts-modal',
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
      }
    },
    methods: {
      resetPassword() {
        const config = {
          method: 'put',
          url: `admin/user/${this.user.id}/reset-login-attempts`
        }
        this.isRequestPending = true;
        this.$store.dispatch('requests/perform', config).then(
          (response) => {
            this.isRequestPending = false;
            this.uuidMxSet('text', response.data.message, 'the-snack-bar')
            this.uuidMxSet('color', 'success', 'the-snack-bar')
            this.uuidMxSet('active', true, 'the-snack-bar')
            // TODO emit forward
            this.user.attempts = 0
            this.$emit('close')
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