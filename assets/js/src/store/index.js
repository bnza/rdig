import Vue from 'vue'
import Vuex from 'vuex'
import account from './account'
import components from './components'
import requests from './requests'

Vue.use(Vuex)

const SET_TOKEN = 'SET_TOKEN'

export const mutations = {
  [SET_TOKEN] (state, token) {
    if (!state.token) {
      state.token = token
    }
  }
}

export const state = {
  contextTypes: [
    { id: 'B', 'name': 'bench' },
    { id: 'D', 'name': 'drain' },
    { id: 'F', 'name': 'fill' },
    { id: 'G', 'name': 'grave' },
    { id: 'L', 'name': 'locus' },
    { id: 'P', 'name': 'pitt' },
    { id: 'W', 'name': 'wall' }
  ],
  tables: {
    site: {
      item: {
        toolbar: 'SiteItemDataToolbar'
      },
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
          width: '10%'
        },
        {
          text: 'Name',
          value: 'name',
          class: 'subheading'
        }
      ]
    },
    area: {
      label: 'Area',
      headers: [
        {
          text: 'ID',
          value: 'id',
          class: 'subheading',
          width: '20%'
        },
        {
          text: 'Site',
          value: 'site.code',
          class: 'subheading',
          width: '10%'
        },
        {
          text: 'Code',
          value: 'code',
          class: 'subheading',
          width: '10%'
        },
        {
          text: 'Name',
          value: 'name',
          class: 'subheading'
        }
      ]
    },
    campaign: {
      label: 'Campaign',
      headers: [
        {
          text: 'ID',
          value: 'id',
          class: 'subheading',
          width: '20%'
        },
        {
          text: 'Code',
          value: 'site.code',
          class: 'subheading',
          width: '20%'
        },
        {
          text: 'Site',
          value: 'site.code',
          class: 'subheading',
          width: '20%'
        },
        {
          text: 'Year',
          value: 'year',
          class: 'subheading'
        }
      ]
    },
    context: {
      label: 'Context',
      headers: [
        {
          text: 'ID',
          value: 'id',
          class: 'subheading',
          width: '20%'
        },
        {
          text: 'Site',
          value: 'site.code',
          class: 'subheading',
          width: '10%'
        },
        {
          text: 'Area',
          value: 'area.code',
          class: 'subheading',
          width: '10%'
        },
        {
          text: 'Type',
          value: 'type',
          class: 'subheading',
          width: '10%'
        },
        {
          text: 'Num',
          value: 'num',
          class: 'subheading'
        }
      ]
    },
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
          class: 'subheading'
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
          class: 'subheading'
        },
        {
          text: 'Name',
          value: 'name',
          class: 'subheading'
        }
      ]
    }
  },
  token: ''
}

export const getters = {
  contextTypeName: (state) => (id) => {
    return state.contextTypes.find((item) => {
      return item.id === id
    })
  }
}

const store = new Vuex.Store({
  strict: true,
  state,
  getters,
  mutations,
  modules: {
    account: account,
    components: components,
    requests: requests
  }
})

export default store
