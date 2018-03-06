<template>
    <div class="field">
        <label v-if="label" class="label">{{label}}</label>
        <!--<p class="help" v-bind:class="helpClassObject">{{helpMessage.message}}</p>-->
    </div>
</template>

<script>
    import FormControl from './FormControl'

    export default {
        components: {
            FormControl
        },
        props: {
            label: {
                type: String,
                default: ''
            },
            helpMessage: {
                type: Object,
                default: function () {
                    return {
                        message: '',
                        className: ''
                    }
                }
            }
        },
        computed: {
            helpClassObject: function () {
                if (this.helpMessage.className) {
                    let classObject = {}
                    classObject[this.helpMessage.className] = true
                    return classObject
                }
                return false
            }
        },
        name: "FormField"
    }
</script>

<style scoped>

</style>