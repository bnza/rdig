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
    context: {label: 'Context'},
    bucket: {label: 'Bucket'},
    user: {
      item: {
        toolbar: 'UserItemDataToolbar'
      },
      group: 'admin',
      label: 'User',
      headers: [
        {
          text: 'ID',
          value: 'id',
          class: 'subheading',
          width: '20%'
        },
        {
          text: 'Username',
          value: 'username',
          class: 'subheading',
        },
        {
          text: 'Roles',
          value: 'roles',
          class: 'subheading'
        }
      ]
    },
    'user-allowed-sites': {
      group: 'admin',
      hidden: true,
      label: 'User\'s privileges on site',
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
        },
        {
          text: 'Name',
          value: 'name',
          class: 'subheading'
        }
      ]
    }
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
