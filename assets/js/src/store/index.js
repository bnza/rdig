import Vue from 'vue'
import Vuex from 'vuex'
import account from './account'
import components from './components'
import requests from './requests'

Vue.use(Vuex)

export const state = {
  tables: {
    site: {
      label: 'Site',
      maxWidth: '450px',
      headers: [
        {
          text: 'ID',
          value: 'id',
          class: 'subheading',
          width: '20%'
        },
        {
          text: 'Code',
          value: 'code',
          class: 'subheading',
          width: '20%'
        },
        {
          text: 'Name',
          value: 'name',
          class: 'subheading'
        }
      ]
    },
    area: {label: 'Area'},
    su: {label: 'Stratigraphic unit'},
    bucket: {label: 'Bucket'}
  }
}

const store = new Vuex.Store({
  strict: true,
  state,
  modules: {
    account: account,
    components: components,
    requests: requests
  }
})

export default store
