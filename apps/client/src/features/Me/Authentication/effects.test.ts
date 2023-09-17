import assert from 'assert'
import { authenticateEffect, reAuthenticateEffect } from 'features/Me/Authentication/effects'
import { authenticate, authenticated, notReAuthenticated, error } from 'features/Me/Authentication/slice'
import { IUser } from 'models/user'
import { call, put } from 'redux-saga/effects'
import { get, post } from 'services/api'
import { save } from 'services/storage'
import { userMock } from 'test-utils'

describe('Effects/Authentication', () => {
  describe('Authenticate', () => {
    it('handles authentication and token storage', () => {
      const action = authenticate({ username: 'test', password: 'test' })
      const effect = authenticateEffect(action)

      assert.deepEqual(
        effect.next().value,
        call(post, '/auth', { username: 'test', password: 'test' })
      )

      const tokenPayload = { token: 'auth_token' }

      assert.deepEqual(
        effect.next(tokenPayload).value,
        call(save, 'token', tokenPayload.token)
      )
    })

    it('handles error', () => {
      const action = authenticate({ username: 'test', password: 'test' })
      const effect = authenticateEffect(action)

      assert.deepEqual(
        effect.next().value,
        call(post, '/auth', { username: 'test', password: 'test' })
      )

      const errorMock: Error = { name: 'test', message: 'test' }

      assert.deepEqual(
        effect.throw(errorMock).value,
        put(error())
      )
    })
  })

  describe('ReAuthenticate', () => {
    it('handles re-authentication', () => {
      const effect = reAuthenticateEffect()

      assert.deepEqual(
        effect.next().value,
        call(get, '/me')
      )

      const authenticatedUser: IUser = userMock

      assert.deepEqual(
        effect.next(authenticatedUser).value,
        put(authenticated(authenticatedUser.id)),
      )
    })

    it('handles not re-authenticated error', () => {
      const effect = reAuthenticateEffect()

      assert.deepEqual(
        effect.next().value,
        call(get, '/me')
      )

      const error: Error = { name: 'Forbidden', message: 'forbidden' }

      assert.deepEqual(
        effect.throw(error).value,
        put(notReAuthenticated())
      )
    })
  })
})
