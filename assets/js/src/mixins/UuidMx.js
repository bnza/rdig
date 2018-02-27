import {mapGetters, mapActions} from 'vuex'

export default {
  data: function () {
    return {
      uuid: ''
    }
  },
  props: {
    $_UuidMx_register: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    ...mapGetters('components', {
      $_UuidMx_getFn: 'value'
    })
  },
  methods: {
    ...mapActions('components', {
      $_UuidMx_setFn: 'set'
    }),
    $_UuidMx_get: function (key, uuid) {
      uuid = uuid || this.uuid
      return this.$_UuidMx_getFn(uuid, key)
    },
    $_UuidMx_set: function (key, value, uuid) {
      uuid = uuid || this.uuid
      return this.$_UuidMx_setFn({
        uuid: uuid,
        key: key,
        value: value
      })
    }
  },
  created () {
    let uuid = ''
    if (this.$options.name.startsWith('the-')) {
      uuid = this.$options.name
    } else if (this.$_UuidMx_register) {
      uuid = `${this.$options.name}-${this._uid}`
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
