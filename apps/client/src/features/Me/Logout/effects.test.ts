import assert from 'assert'
import { logoutEffect } from 'features/Me/Logout/effects'
import { loggedOut, error } from 'features/Me/Logout/slice'
import { call, put } from 'redux-saga/effects'
import { remove } from 'services/storage'

describe('Effects/Logout', () => {
  describe('Logout', () => {
    it('handles logging out', () => {
      const effect = logoutEffect()

      assert.deepEqual(
        effect.next().value,
        call(remove, 'token')
      )

      assert.deepEqual(
        effect.next().value,
        put(loggedOut())
      )
    })

    it('handles errors', () => {
      const effect = logoutEffect()

      assert.deepEqual(
        effect.next().value,
        call(remove, 'token')
      )

      const errorMock: Error = { name: 'error', message: 'test' }

      assert.deepEqual(
        effect.throw(errorMock).value,
        put(error())
      )
    })
  })
})
