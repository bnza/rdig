<template>
    <article v-if="appMessage" class="message" v-bind:class="appMessageClass">
        <div class="message-body">
            {{appMessage}}
        </div>
    </article>
</template>

<script>
  import MessagesMixin from '../mixins/MessagesMixin'

  export default {
    mixins: [
      MessagesMixin
    ],
    name: "MessagesContainer"
  }
</script>

<style scoped>

</style>