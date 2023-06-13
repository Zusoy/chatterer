import assert from 'assert'
import { fetchAllEffect } from 'features/Channels/effects'
import { fetchAll, received, error } from 'features/Channels/slice'
import { Channel } from 'models/channel'
import { call, put } from 'redux-saga/effects'
import { get } from 'services/api'

describe('Effects/Channels', () => {
  describe('FetchAll', () => {
    it('fetch and received channels', () => {
      const action = fetchAll('stationId')
      const iterator = fetchAllEffect(action)

      assert.deepEqual(
        iterator.next().value,
        call(get, '/station/stationId/channels')
      )

      const channels: Channel[] = []

      assert.deepEqual(
        iterator.next(channels).value,
        put(received(channels))
      )
    })

    it('handles fetch error', () => {
      const action = fetchAll('stationId')
      const iterator = fetchAllEffect(action)

      assert.deepEqual(
        iterator.next().value,
        call(get, '/station/stationId/channels')
      )

      const errorMock: Error = { name: 'error', message: 'test' }

      assert.deepEqual(
        iterator.throw(errorMock).value,
        put(error())
      )
    })
  })
})
