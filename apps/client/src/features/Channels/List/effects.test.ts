import { describe, test, expect } from 'vitest'
import { call, put } from 'redux-saga/effects'
import { get, ApiErrorResponse } from 'services/api'
import { fetchAllEffect } from 'features/Channels/List/effects'
import { received, error, fetchAll } from 'features/Channels/slice'
import { stationMock, channelMock } from 'test-utils'

describe('Effects/Channels/List', () => {
  describe('FetchAll', () => {
    test('it handles fetch all', () => {
      const action = fetchAll(stationMock.id)
      const effect = fetchAllEffect(action)

      expect(effect.next().value)
        .toStrictEqual(call(get, `/station/${stationMock.id}/channels`))

      expect(effect.next([channelMock]).value)
        .toStrictEqual(put(received([channelMock])))
    })

    test('it handles errors', () => {
      const action = fetchAll(stationMock.id)
      const effect = fetchAllEffect(action)

      expect(effect.next().value)
        .toStrictEqual(call(get, `/station/${stationMock.id}/channels`))

      const mockedError = new ApiErrorResponse(
        403,
        '/*',
        {
          code: 0,
          message: 'Forbidden',
          type: 'InvalidCredentials',
          extra: {}
        }
      )

      expect(effect.throw(mockedError).value)
        .toStrictEqual(put(error()))
    })
  })
})
