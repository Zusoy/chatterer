import assert from 'assert'
import { call, put } from 'redux-saga/effects'
import { get } from 'services/api'
import { fetchAllEffect } from 'features/Stations/List/effects'
import { received, error } from 'features/Stations/List/slice'
import { IStation } from 'models/station'

describe('Effects/Stations/List', () => {
  describe('FetchAll', () => {
    it('fetch and received stations', () => {
      const effect = fetchAllEffect()

      assert.deepEqual(
        effect.next().value,
        call(get, '/stations')
      )

      const stations: IStation[] = []

      assert.deepEqual(
        effect.next(stations).value,
        put(received(stations))
      )
    })

    it('handles fetch error', () => {
      const effect = fetchAllEffect()

      assert.deepEqual(
        effect.next().value,
        call(get, '/stations')
      )

      const errorMock: Error = { name: 'error', message: 'test' }

      assert.deepEqual(
        effect.throw(errorMock).value,
        put(error())
      )
    })
  })
})
