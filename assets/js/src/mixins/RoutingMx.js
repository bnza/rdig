export const routingMxStringify = function (key, value) {
  switch (key) {
    case 'matched':
    case 'fullPath':
    case 'path':
      return undefined
    default:
      return value
  }
}

export const routingMxClone = function (route, stringifyFn) {
  stringifyFn = stringifyFn || routingMxStringify
  return JSON.parse(JSON.stringify(route, stringifyFn))
}

export const routingMxMerge = function (target, source) {
  return JSON.parse(JSON.stringify(source), (key, value) => {
    switch (key) {
      case 'matched':
      case 'fullPath':
      case 'path':
        return undefined
      default:
        return target.hasOwnProperty(key) ? target[key] : value
    }
  })
}

export const routingMxGetReadRoute = function (route) {
  const r = new RegExp(`${route.params.action}$`)
  return routingMxClone(route, (key, value) => {
    switch (key) {
      case 'matched':
      case 'fullPath':
      case 'path':
        return undefined
      case 'action':
        return 'read'
      case 'name':
        return value.replace(r, 'read')
      default:
        return value
    }
  })
}

export const routingMxBaseListPath = function (table, prefix, parent) {
  return `/${routingMxGetListUrl(table, prefix, parent)}`
}

export const routingMxBaseItemPath = function (table, id, prefix, parent) {
  return `/${routingMxGetItemUrl(table, id, prefix, parent)}`
}

export const routingMxListPath = function (table, prefix, parent) {
  return `${routingMxBaseListPath(table, prefix, parent)}/read`
}

export const routingMxListActionPath = function (action, table, prefix, parent) {
  return `/${routingMxGetListUrl(table, prefix, parent)}/${action}`
}

export const routingMxItemActionPath = function (action, table, id, prefix, parent) {
  return `/${routingMxGetItemUrl(table, id, prefix, parent)}/${action}`
}

export const routingMxGetItemPath = function (table, id, prefix, parent) {
  return `/${routingMxGetItemUrl(table, id, prefix, parent)}/read`
}

export const routingMxGetListUrl = function (table, prefix, parent) {
  let url = prefix || 'data'
  if (parent) {
    url += `/${parent.table}/${parent.id}/${table}`
  } else {
    url += `/${table}`
  }
  return url
}

export const routingMxGetItemUrl = function (table, id, prefix, parent) {
  // if id is in the from 100,100 (join tables) extract the second value
  if (id) {
    if (typeof id === 'string') {
      id = id.split(',').pop()
    }
    return `${routingMxGetListUrl(table, prefix, parent)}/${id}`
  }
  throw new Error('ID must be supplied')
}

export default {
  computed: {
    routingMxBasePath () {
      return `/${this.routingMxListUrl}`
    },
    routingMxListPath () {
      return `${this.routingMxBasePath}/read`
    },
    routingMxCreatePath () {
      return `${this.routingMxBasePath}/create`
    },
    routingMxItemPath () {
      return `/${this.routingMxItemUrl}/read`
    },
    routingMxItemUrl () {
      return routingMxGetItemUrl(this.table__, this.id__, this.prefix__, this.parent__)
    },
    routingMxListUrl () {
      return routingMxGetListUrl(this.table__, this.prefix__, this.parent__)
    }
  },
  methods: {
    routingMxGetChildListPath (childTable) {
      return childTable
        ? `/${this.routingMxItemUrl}/${childTable}/read`
        : false
    },
    routingMxGetItemPath (id) {
      return routingMxGetItemPath(this.table__, id, this.prefix__, this.parent__)
    },
    routingMxGetDeletePath (id) {
      return routingMxItemActionPath('delete', this.table__, id, this.prefix__, this.parent__)
    },
    routingMxGetUpdatePath (id) {
      return routingMxItemActionPath('update', this.table__, id, this.prefix__, this.parent__)
    },
    routingMxGoToList () {
      this.$router.push(this.routingMxListPath)
    },
    routingMxGoToItem (id) {
      id = id || this.id__
      this.$router.push(this.routingMxGetItemPath(id))
    }
  }
}
