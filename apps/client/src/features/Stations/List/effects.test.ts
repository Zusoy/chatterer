import assert from 'assert'
import { call, put } from 'redux-saga/effects'
import { get } from 'services/api'
import { fetchAllEffect } from 'features/Stations/List/effects'
import { received, error } from 'features/Stations/List/slice'
import { Station } from 'models/station'

describe('Effects/Stations/List', () => {
  describe('FetchAll', () => {
    it('fetch and received stations', () => {
      const iterator = fetchAllEffect()

      assert.deepEqual(
        iterator.next().value,
        call(get, '/stations')
      )

      const stations: Station[] = []

      assert.deepEqual(
        iterator.next(stations).value,
        put(received(stations))
      )
    })

    it('handles fetch error', () => {
      const iterator = fetchAllEffect()

      assert.deepEqual(
        iterator.next().value,
        call(get, '/stations')
      )

      const errorMock: Error = { name: 'error', message: 'test' }

      assert.deepEqual(
        iterator.throw(errorMock).value,
        put(error())
      )
    })
  })
})
