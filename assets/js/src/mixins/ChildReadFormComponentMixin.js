export const computed = {
  $_ChildReadFormComponent_ready: function () {
    return !!this.$_ChildReadFormComponent_vm
  }
}

export const methods = {
  $_ChildReadFormComponent_back: function () {
    this.$_ChildReadFormComponent_vm.back()
  },
  $_ChildReadFormComponent_openDeleteModal: function () {
    this.$_ChildReadFormComponent_vm.isDeleteModalActive = true
  }
}

export default {
  data: function () {
    return {
      $_ChildReadFormComponent_vm: null
    }
  },
  computed: computed,
  methods: methods,
  mounted: function () {
    this.$_ChildReadFormComponent_vm = this.$refs.childReadFormComponent
  }
}
