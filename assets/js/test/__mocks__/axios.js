const errorResponse = {
  'data': 'Bad credentials',
  'status': 403,
  'statusText': 'Forbidden',
  'headers': {
    'date': 'Fri, 05 Jan 2018 16:08:42 GMT',
    'x-debug-token-link': 'http://www.rdig.local/_profiler/07042c',
    'server': 'Apache',
    'x-powered-by': 'PHP/7.1.11',
    'content-type': 'text/html;' +
    ' charset=UTF-8',
    'cache-control': 'max-age=0, private, must-revalidate, no-cache, private',
    'connection': 'Keep-Alive',
    'keep-alive': 'timeout=15, max=100',
    'content-length': '15',
    'x-debug-token': '07042c'
  },
  'config': {
    'transformRequest': {},
    'transformResponse': {},
    'timeout': 0,
    'xsrfCookieName': 'XSRF-TOKEN',
    'xsrfHeaderName': 'X-XSRF-TOKEN',
    'maxContentLength': -1,
    'headers': {
      'Accept': 'application/json,' +
      ' text/plain, */*',
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    'method': 'post',
    'url': '/login',
    'data': 'username=kjlkjlk&password=jkjlkj' },
  'request': {}
}

let response
let error

const login = (data, config) => {
  const credentials = 'username=pippo&password=pluto'

  if (credentials === data) {
    response = { 'user': {
      'username': 'pippo'
    }}
    return true
  } else {
    error = new Error()
    error.response = error
    return false
  }
}

const success = () => {
  response = { 'status': 200 }
  return true
}

const reject = () => {
  response = {
    status: 500,
    data: 'Server error'
  }
  error = new Error('Server error')
  error.response = response
  return false
}

const resolveUrl = (url) => {
  switch (url) {
    case '/login':
      return login
    case '/reject':
      return reject
    default:
      return success
  }
}

const axios = {
  mergeOptions: function (url, data, method, config) {
    config.url = url
    config.method = method
    config.data = data
    return config
  },
  post: function (url, data, config) {
    this.request(this.mergeOptions(url, data, 'post', config))
  },
  request: function (config) {
    return new Promise((resolve, reject) => {
      let f = resolveUrl(config.url)
      const success = f(config.data, config)
      process.nextTick(
        () =>
          success
            ? resolve(response)
            : reject(error)
      )
    })
  }
}

export default axios
