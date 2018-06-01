import Vue from 'vue'
import Vuex from 'vuex'
import account from './account'
import components from './components'
import requests from './requests'

Vue.use(Vuex)

const SET_TOKEN = 'SET_TOKEN'
const SET_SITE_FILTER = 'SET_SITE_FILTER'

export const mutations = {
  [SET_TOKEN] (state, token) {
    state.token = token
  },
  [SET_SITE_FILTER] (state, siteFilter) {
    state.siteFilter = siteFilter
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
  bucketTypes: [
    { id: 'O', 'name': 'object' },
    { id: 'P', 'name': 'pottery' },
    { id: 'S', 'name': 'sample' }
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
        },
        {
          text: 'Description',
          value: 'description',
          class: 'subheading'
        }
      ]
    },
    bucket: {
      label: 'Bucket',
      item: {
        toolbar: 'BucketItemDataToolbar'
      },
      headers: [
        {
          text: 'ID',
          value: 'id',
          class: 'subheading'
        },
        {
          text: 'Code',
          value: 'site.code',
          class: 'subheading'
        },
        {
          text: 'Site',
          value: 'site.code',
          class: 'subheading'
        },
        {
          text: 'Year',
          value: 'campaign.year',
          class: 'subheading'
        },
        {
          text: 'Area',
          value: 'area.code',
          class: 'subheading'
        },
        {
          text: 'Context',
          value: 'context.num',
          class: 'subheading'
        },
        {
          text: 'Group',
          value: 'group',
          class: 'subheading',
          public: false
        },
        {
          text: 'Num',
          value: 'num',
          class: 'subheading'
        }
      ]
    },
    finding: {
      label: 'Finding',
      headers: [
        {
          text: 'ID',
          value: 'id',
          class: 'subheading'
        },
        {
          text: 'Code',
          value: 'site.code',
          class: 'subheading'
        },
        {
          text: 'Site',
          value: 'site.code',
          class: 'subheading'
        },
        {
          text: 'Year',
          value: 'campaign.year',
          class: 'subheading'
        },
        {
          text: 'Context',
          value: 'context.num',
          class: 'subheading'
        },
        {
          text: 'Num',
          value: 'num',
          class: 'subheading'
        },
        {
          text: 'Chronology',
          value: 'voc__f__chronology.value',
          class: 'subheading'
        },
        {
          text: 'Remarks',
          value: 'remarks',
          class: 'subheading'
        }
      ]
    },
    object: {
      label: 'Object',
      list: {
        toolbar: 'FindingListDataToolbar'
      },
      headers: [
        {
          text: 'ID',
          value: 'id',
          class: 'subheading'
        },
        {
          text: 'Code',
          value: 'site.code',
          class: 'subheading'
        },
        {
          text: 'Site',
          value: 'site.code',
          class: 'subheading'
        },
        {
          text: 'Year',
          value: 'campaign.year',
          class: 'subheading'
        },
        {
          text: 'Context',
          value: 'context.num',
          class: 'subheading'
        },
        {
          text: 'Num',
          value: 'num',
          class: 'subheading'
        },
        {
          text: 'Object no.',
          value: 'no',
          class: 'subheading'
        },
        {
          text: 'Date of retrieval',
          value: 'retrievalDate',
          class: 'subheading'
        },
        {
          text: 'Class',
          value: 'class.value',
          class: 'subheading'
        },
        {
          text: 'Type',
          value: 'type.value',
          class: 'subheading'
        },
        {
          text: 'Sub Type',
          value: 'subType',
          class: 'subheading'
        },
        {
          text: 'Material Class',
          value: 'materialClass.value',
          class: 'subheading'
        },
        {
          text: 'Material Type',
          value: 'materialType.value',
          class: 'subheading'
        },
        {
          text: 'Technique',
          value: 'technique.value',
          class: 'subheading'
        },
        {
          text: 'Decoration',
          value: 'decoration.value',
          class: 'subheading'
        },
        {
          text: 'Color',
          value: 'color.value',
          class: 'subheading'
        },
        {
          text: 'Preservation state',
          value: 'preservation.value',
          class: 'subheading'
        },
        {
          text: 'Coord N',
          value: 'coordN',
          class: 'subheading'
        },
        {
          text: 'Coord E',
          value: 'coordE',
          class: 'subheading'
        },
        {
          text: 'Coord Z',
          value: 'coordZ',
          class: 'subheading'
        },
        {
          text: 'Fragments',
          value: 'fragments',
          class: 'subheading'
        },
        {
          text: 'Height',
          value: 'height',
          class: 'subheading'
        },
        {
          text: 'Length',
          value: 'length',
          class: 'subheading'
        },
        {
          text: 'Width',
          value: 'width',
          class: 'subheading'
        },
        {
          text: 'Thickness',
          value: 'thickness',
          class: 'subheading'
        },
        {
          text: 'Diameter',
          value: 'diameter',
          class: 'subheading'
        },
        {
          text: 'Perforation diameter',
          value: 'perforationDiameter',
          class: 'subheading'
        },
        {
          text: 'Weight',
          value: 'weight',
          class: 'subheading'
        },
        {
          text: 'Chronology',
          value: 'chronology.value',
          class: 'subheading'
        },
        {
          text: 'Photo',
          value: 'photo',
          class: 'subheading'
        },
        {
          text: 'Drawing',
          value: 'drawing',
          class: 'subheading'
        },
        {
          text: 'Year of conservation',
          value: 'conservationYear',
          class: 'subheading'
        },
        {
          text: 'Location',
          value: 'location',
          class: 'subheading'
        },
        {
          text: 'Envanterlik',
          value: 'envanterlik',
          class: 'subheading'
        },
        {
          text: 'Etutluk',
          value: 'etutluk',
          class: 'subheading'
        },
        {
          text: 'Description',
          value: 'description',
          class: 'subheading'
        },
        {
          text: 'Remarks',
          value: 'remarks',
          class: 'subheading'
        }
      ]
    },
    pottery: {
      label: 'Pottery',
      list: {
        toolbar: 'FindingListDataToolbar'
      },
      headers: [
        {
          text: 'ID',
          value: 'id',
          class: 'subheading'
        },
        {
          text: 'Code',
          value: 'site.code',
          class: 'subheading'
        },
        {
          text: 'Site',
          value: 'site.code',
          class: 'subheading'
        },
        {
          text: 'Year',
          value: 'campaign.year',
          class: 'subheading'
        },
        {
          text: 'Context',
          value: 'context.num',
          class: 'subheading'
        },
        {
          text: 'Num',
          value: 'num',
          class: 'subheading'
        },
        {
          text: 'Class',
          value: 'class.value',
          class: 'subheading'
        },
        {
          text: 'Shape',
          value: 'shape.value',
          class: 'subheading'
        },
        {
          text: 'Preservation',
          value: 'preservation.value',
          class: 'subheading'
        },
        {
          text: 'Technique',
          value: 'technique.value',
          class: 'subheading'
        },
        {
          text: 'Inclusions Type',
          value: 'inclusionsType.value',
          class: 'subheading'
        },
        {
          text: 'Inclusions Size',
          value: 'inclusionsSize.value',
          class: 'subheading'
        },
        {
          text: 'Inclusions Frequency',
          value: 'inclusionsFrequecy.value',
          class: 'subheading'
        },
        {
          text: 'Inner Surface Treatment',
          value: 'innerSurfaceTreatment.value',
          class: 'subheading'
        },
        {
          text: 'Outer Surface Treatment',
          value: 'outerSurfaceTreatment.value',
          class: 'subheading'
        },
        {
          text: 'Inner Decoration',
          value: 'innerDecoration.value',
          class: 'subheading'
        },
        {
          text: 'Outer Decoration',
          value: 'outerDecoration.value',
          class: 'subheading'
        },
        {
          text: 'Firing',
          value: 'firing.value',
          class: 'subheading'
        },
        {
          text: 'Inner Color',
          value: 'innerColor.value',
          class: 'subheading'
        },
        {
          text: 'Outer Color',
          value: 'outerColor.value',
          class: 'subheading'
        },
        {
          text: 'Core Color',
          value: 'coreColor.value',
          class: 'subheading'
        },
        {
          text: 'Rim Diameter',
          value: 'rimDiameter',
          class: 'subheading'
        },
        {
          text: 'Rim Width',
          value: 'rimWidth',
          class: 'subheading'
        },
        {
          text: 'Wall Width',
          value: 'wallWidth',
          class: 'subheading'
        },
        {
          text: 'Max Wall Diameter',
          value: 'maxWallDiameter',
          class: 'subheading'
        },
        {
          text: 'Base Width',
          value: 'baseWidth',
          class: 'subheading'
        },
        {
          text: 'Base Height',
          value: 'baseHeight',
          class: 'subheading'
        },
        {
          text: 'Base Diameter',
          value: 'baseDiameter',
          class: 'subheading'
        },
        {
          text: 'Height',
          value: 'height',
          class: 'subheading'
        },
        {
          text: 'Restored',
          value: 'restored',
          class: 'subheading'
        },
        {
          text: 'Drawing Number',
          value: 'drawingNumber',
          class: 'subheading'
        },
        {
          text: 'Chronology',
          value: 'chronology.value',
          class: 'subheading'
        },
        {
          text: 'Remarks',
          value: 'remarks',
          class: 'subheading'
        }
      ]
    },
    sample: {
      label: 'Sample',
      list: {
        toolbar: 'FindingListDataToolbar'
      },
      headers: [
        {
          text: 'ID',
          value: 'id',
          class: 'subheading'
        },
        {
          text: 'Code',
          value: 'site.code',
          class: 'subheading'
        },
        {
          text: 'Site',
          value: 'site.code',
          class: 'subheading'
        },
        {
          text: 'Year',
          value: 'campaign.year',
          class: 'subheading'
        },
        {
          text: 'Context',
          value: 'context.num',
          class: 'subheading'
        },
        {
          text: 'Num',
          value: 'num',
          class: 'subheading'
        },
        {
          text: 'Type',
          value: 'voc__s__type.value',
          class: 'subheading'
        },
        {
          text: 'Status',
          value: 'status',
          class: 'subheading'
        },
        {
          text: 'Chronology',
          value: 'voc__f__chronology.value',
          class: 'subheading'
        },
        {
          text: 'Remarks',
          value: 'remarks',
          class: 'subheading'
        }
      ]
    },
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
  token: '',
  siteFilter: null
}

export const getters = {
  contextTypeName: (state) => (id) => {
    return state.contextTypes.find((item) => {
      return item.id === id
    })
  },
  bucketTypeName: (state) => (id) => {
    return state.bucketTypes.find((item) => {
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
