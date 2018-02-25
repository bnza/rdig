import {mapGetters, mapActions} from 'vuex'

export default {
  data: function () {
    return {
      $_UuidMx_uuid: 0
    }
  },
  created: function () {
    if (this.$options.name.startsWith('the-')) {
      this.$_UuidMx_uuid = this.$options.name
    } else {
      this.$_UuidMx_uuid = 0
    }
    this.$store.dispatch('components/add', this.$_UuidMx_uuid).then(
      (uuid) => {
        if (!this.$options.name.startsWith('the-')) {
          this.$_UuidMx_uuid = `${this.$options.name}-${uuid}`
        }
      }
    )
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
      uuid = uuid || this.$_UuidMx_uuid
      return this.$_UuidMx_getFn(uuid, key)
    },
    $_UuidMx_set: function (key, value, uuid) {
      uuid = uuid || this.$_UuidMx_uuid
      return this.$_UuidMx_setFn({
        uuid: uuid,
        key: key,
        value: value
      })
    }
  }
}
