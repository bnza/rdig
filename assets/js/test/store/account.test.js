/* global describe, it, expect, jest, beforeEach */
import {state as baseState, mutations, getters, actions} from '../../src/store/account/index'

jest.mock('axios')

const { SET_USER, SET_AUTH_ERROR, CLEAR_AUTH_ERROR } = mutations

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

describe('store.request store module', () => {
  let state = null

  beforeEach(() => {
    jest.resetModules()
    jest.clearAllMocks()
    state = JSON.parse(JSON.stringify(baseState))
  })

  describe('getters', () => {
    describe('errorMessage', () => {
      it('returns a string error if "authError" prop is set', () => {
        state.authError = errorResponse
        expect(getters.errorMessage(state)).toEqual(errorResponse.data)
      })
    })
  })

  describe('mutations', () => {
    it('SET_USER', () => {
      const user = {'username': 'pippo'}
      mutations.SET_USER(state, user)
      expect(state.user).toEqual(user)
    })

    it('SET_AUTH_ERROR', () => {
      SET_AUTH_ERROR(state, errorResponse)
      expect(state.authError).toEqual(errorResponse)
    })

    it('CLEAR_AUTH_ERROR', () => {
      SET_AUTH_ERROR(state, errorResponse)
      CLEAR_AUTH_ERROR(state)
      expect(state.authError).toBeFalsy()
    })
  })

  describe('actions', () => {
    describe('login', () => {
      it('calls the expected mutations/actions number when rejected', async () => {
        let commitMock = jest.fn()
        let dispatchMock = jest.fn((type, payload) => {
          if (type === 'requests/perform') {
            throw new Error()
          }
        })
        try {
          await actions.login({commit: commitMock, dispatch: dispatchMock}, {url: '/reject'})
        } catch (e) {
          expect(commitMock).toHaveBeenCalledTimes(4)
          expect(dispatchMock).toHaveBeenCalledTimes(1)
        }
      })

      it('calls the expected mutations/actions when rejected', async () => {
        let credentials = 'username=pippo&password=wrong'
        let commitMock = jest.fn()
        let dispatchMock = jest.fn((type, payload) => {
          if (type === 'requests/perform') {
            throw new Error()
          }
        })
        try {
          await actions.login({commit: commitMock, dispatch: dispatchMock}, credentials)
        } catch (e) {
          expect(commitMock.mock.calls[0]).toEqual(['CLEAR_AUTH_ERROR'])
          expect(commitMock.mock.calls[1]).toEqual(['SET_REQ_PENDING', true])
          expect(dispatchMock.mock.calls[0]).toEqual(['requests/perform',
            {'data': 'username=pippo&password=wrong',
              'method': 'post',
              'url': '/login'},
              {'root': true}])
          expect(commitMock.mock.calls[2]).toEqual(['SET_REQ_PENDING', false])
          expect(commitMock.mock.calls[3]).toEqual(['SET_AUTH_ERROR', e.response])
        }
      })

      it('calls the expected mutations/actions number when success', async () => {
        let credentials = 'username=pippo&password=pluto'
        let commitMock = jest.fn()
        let dispatchMock = jest.fn((type, payload) => {
          if (type === 'requests/perform') {
            return { 'user': {
              'username': 'pippo'
            }}
          }
        })
        await actions.login({commit: commitMock, dispatch: dispatchMock}, credentials)
        expect(commitMock).toHaveBeenCalledTimes(4)
        expect(dispatchMock).toHaveBeenCalledTimes(1)
      })

      it('calls the expected mutations/actions when success', async () => {
        let credentials = 'username=pippo&password=pluto'
        let response = {'user': {
          'username': 'pippo'
        }}
        let commitMock = jest.fn()
        let dispatchMock = jest.fn((type, payload) => {
          if (type === 'requests/perform') {
            return response
          }
        })
        try {
          await actions.login({commit: commitMock, dispatch: dispatchMock}, credentials)
        } catch (e) {
          expect(commitMock.mock.calls[0]).toEqual(['CLEAR_AUTH_ERROR'])
          expect(commitMock.mock.calls[1]).toEqual(['SET_REQ_PENDING', true])
          expect(dispatchMock.mock.calls[0]).toEqual(['requests/perform',
            {'data': 'username=pippo&password=pluto',
              'method': 'post',
              'url': '/login'}])
          expect(commitMock.mock.calls[2]).toEqual(['SET_REQ_PENDING', false])
          expect(commitMock.mock.calls[3]).toEqual(['SET_USER', response.user])
        }
      })
    })
  })
})
