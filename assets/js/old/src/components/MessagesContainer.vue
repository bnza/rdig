<template>
    <section>
        <article v-for="message in $store.state.messages.all" class="message" v-bind:class="message.className">
            <div class="message-body">
                {{message.body}}
            </div>
        </article>
    </section>
</template>

<script>
  export default {
    name: "MessagesContainer"
  }
</script>

<style scoped>

</style>