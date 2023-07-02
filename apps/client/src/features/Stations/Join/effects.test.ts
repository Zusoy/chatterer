import assert from 'assert'
import { joinStationEffect } from 'features/Stations/Join/effects'
import { join, joined } from 'features/Stations/Join/slice'
import { call, put } from 'redux-saga/effects'
import { post } from 'services/api'
import { success } from 'services/notification'
import { stationMock } from 'test-utils'

describe('Effects/Stations/Join', () => {
  describe('JoinStation', () => {
    it('join station and notify', () => {
      const action = join({ token: 'invitation_token' })
      const effect = joinStationEffect(action)

      assert.deepEqual(
        effect.next().value,
        call(post, '/stations/join', { token: 'invitation_token' })
      )

      assert.deepEqual(
        effect.next(stationMock).value,
        put(joined())
      )

      assert.deepEqual(
        effect.next().value,
        call(success, 'Welcome to the station Company !')
      )
    })
  })
})
