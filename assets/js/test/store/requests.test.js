/* global describe, it, expect, jest, beforeEach */
import { state as baseState, mutations, getters, actions } from '~/js/src/store/requests'

describe('store.request store module', () => {
  let state = null

  beforeEach(() => {
    jest.resetModules()
    jest.clearAllMocks()
    state = JSON.parse(JSON.stringify(baseState))
  })

  describe('state', () => {
    it('"all" prop is an empty array', () => {
      expect(state.all).toEqual([])
    })

    it('"pending" prop is an empty array', () => {
      expect(state.pending).toEqual([])
    })
  })

  describe('mutations', () => {
    describe('NEW_REQUEST', () => {
      it('returns an index value', () => {
        const request = { url: '/login' }
        expect(mutations.NEW_REQUEST(state, request)).toEqual(0)
        expect(mutations.NEW_REQUEST(state, request)).toEqual(1)
      })

      it('pushes the request into "all" prop array', () => {
        const requests = [
          { url: '/url0' },
          { url: '/url1' }
        ]

        for (var i = 0, len = requests.length; i < len; i++) {
          let index = mutations.NEW_REQUEST(state, requests[i])
          expect(state.all[index]).toEqual(requests[i])
        }
        expect(state.all.length).toEqual(requests.length)
      })

      it('pushes the request into "pending" prop array', () => {
        const requests = [
          { url: '/url0' },
          { url: '/url1' }
        ]

        for (var i = 0, len = requests.length; i < len; i++) {
          let index = mutations.NEW_REQUEST(state, requests[i])
          expect(state.pending).toContain(index)
        }
        expect(state.pending).toHaveLength(requests.length)
      })

      it('"pending" prop array index values matches the right request in "all" prop array', () => {
        const requests = [
          { url: '/url0' },
          { url: '/url1' }
        ]

        for (var i = 0, len = requests.length; i < len; i++) {
          mutations.NEW_REQUEST(state, requests[i])
          let request = state.all[state.pending[i]]
          expect(request).toEqual(requests[i])
        }
        expect(state.pending.length).toEqual(requests.length)
      })
    })

    describe('SET_REQUEST_FULFILLED', () => {
      it('removes the request from "pending" prop array', () => {
        const requests = [
          { url: '/url0' },
          { url: '/url1' }
        ]

        for (var i = 0, len = requests.length; i < len; i++) {
          mutations.NEW_REQUEST(state, requests[i])
        }

        expect(state.pending).toContain(1)

        mutations.SET_REQUEST_FULFILLED(state, 1, 200)

        expect(state.pending).not.toContain(1)
      })

      it('set the "status" prop in the fulfilled request', () => {
        const requests = [
          { url: '/url0' }
        ]

        for (var i = 0, len = requests.length; i < len; i++) {
          mutations.NEW_REQUEST(state, requests[i])
        }

        expect(state.all[0]).not.toHaveProperty('status')
        mutations.SET_REQUEST_FULFILLED(state, 0, 200)
        expect(state.all[0]).toHaveProperty('status', 200)
      })

      it('throws RangeError with out of bounds index', () => {
        const requests = [
          { url: '/url0' }
        ]
        for (var i = 0, len = requests.length; i < len; i++) {
          mutations.NEW_REQUEST(state, requests[i])
        }
        const outOfBounds = () =>  {
          mutations.SET_REQUEST_FULFILLED(state, 1, 200)
        }
        expect(outOfBounds).toThrowError(RangeError)
        expect(outOfBounds).toThrowError('No request found at [1] index')
      })
    })
  })

  describe('getters', () => {
    describe('isPending', () => {
      it('returns false if "pending" prop array is empty', () => {
        expect(state.pending).toEqual([])
        expect(getters.isPending(state)).toBeFalsy()
      })

      it('returns true if "pending" prop array is not empty', () => {
        state.pending.push(0)
        expect(getters.isPending(state)).toBeTruthy()
      })
    })

    describe('isRequestPending', () => {
      it('returns true if given index is in "pending" prop array', () => {
        state.pending.push(0)
        expect(getters.isRequestPending(state, 0)).toBeTruthy()
      })

      it('returns false if given index is not in "pending" prop array', () => {
        expect(getters.isRequestPending(state, 0)).toBeFalsy()
      })
    })

    describe('getByIndex', () => {
      it('returns the right request from "all" prop array', () => {
        state.all = [
          { url: '/url0' },
          { url: '/url1' }
        ]

        for (var i = 0, len = state.all.length; i < len; i++) {
          expect(getters.getByIndex(state, i)).toEqual(state.all[i])
        }
      })
    })
  })

  describe('actions', () => {
    describe('perform', () => {
      it('calls NEW_REQUEST and SET_REQUEST_FULFILLED mutations on success request', async () => {
        jest.mock('axios')
        let commitMock = jest.fn()
        await actions.perform({commit: commitMock, state: state}, {})
        expect(commitMock).toHaveBeenCalledTimes(2)
        expect(commitMock.mock.calls[0]).toEqual(['NEW_REQUEST', {}])
        expect(commitMock.mock.calls[1]).toEqual(['SET_REQUEST_FULFILLED',
          -1, // request were not really pushed
          200,
          ''
        ])
      })

      it('calls NEW_REQUEST and SET_REQUEST_FULFILLED mutations on rejected request', async () => {
        jest.mock('axios')
        let commitMock = jest.fn()
        try {
          await actions.perform({commit: commitMock, state: state}, {url: '/reject'})
        } catch (e) {
          expect(commitMock).toHaveBeenCalledTimes(2)
          expect(commitMock.mock.calls[0]).toEqual(['NEW_REQUEST', {url: '/reject'}])
          expect(commitMock.mock.calls[1]).toEqual(['SET_REQUEST_FULFILLED',
            -1, // request were not really pushed
            500,
            'Server error'
          ])
        }
      })
    })
  })
})
