import {mapGetters, mapActions} from 'vuex'

export const uuidMxSet = function (store, key, value, uuid) {
  store.commit('components/SYNC_SET_VALUE', {
    uuid: uuid,
    key: key,
    value: value
  })
}

export default {
  data: function () {
    return {
      uuid: ''
    }
  },
  props: {
    uuidMxRegister: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    ...mapGetters('components', {
      uuidMxGetFn: 'value'
    })
  },
  methods: {
    ...mapActions('components', {
      uuidMxSetFn: 'set'
    }),
    uuidMxGet: function (key, uuid) {
      uuid = uuid || this.uuid
      return this.uuidMxGetFn(uuid, key)
    },
    uuidMxSet: function (key, value, uuid) {
      uuid = uuid || this.uuid
      uuidMxSet(this.$store, key, value, uuid)
    }
  },
  created () {
    let uuid = ''
    if (this.$options.name.startsWith('the-')) {
      uuid = this.$options.name
    } else if (this.uuidMxRegister) {
      this.$store.commit('components/INCREMENT')
      uuid = `${this.$options.name}-${this.$store.state.components.uuid}`
    }
    if (uuid) {
      this.$store.commit('components/ADD_COMPONENT', uuid)
      this.uuid = uuid
    }
  },
  beforeDestroy () {
    this.$store.dispatch('components/remove', this.uuid)
  }
}
