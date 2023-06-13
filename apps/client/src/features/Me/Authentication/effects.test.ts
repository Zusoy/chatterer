import assert from 'assert'
import { authenticateEffect, reAuthenticateEffect } from 'features/Me/Authentication/effects'
import { authenticate, authenticated, notReAuthenticated, error } from 'features/Me/Authentication/slice'
import { User } from 'models/user'
import { call, put } from 'redux-saga/effects'
import { get, post } from 'services/api'
import { userMock } from 'test-utils'

describe('Effects/Authentication', () => {
  describe('Authenticate', () => {
    it('handles authentication', () => {
      const action = authenticate({ username: 'test', password: 'test' })
      const iterator = authenticateEffect(action)

      assert.deepEqual(
        iterator.next().value,
        call(post, '/auth', { username: 'test', password: 'test' })
      )
    })

    it('handles error', () => {
      const action = authenticate({ username: 'test', password: 'test' })
      const iterator = authenticateEffect(action)

      assert.deepEqual(
        iterator.next().value,
        call(post, '/auth', { username: 'test', password: 'test' })
      )

      const errorMock: Error = { name: 'test', message: 'test' }

      assert.deepEqual(
        iterator.throw(errorMock).value,
        put(error())
      )
    })
  })

  describe('ReAuthenticate', () => {
    it('handles re-authentication', () => {
      const iterator = reAuthenticateEffect()

      assert.deepEqual(
        iterator.next().value,
        call(get, '/me')
      )

      const authenticatedUser: User = userMock

      assert.deepEqual(
        iterator.next(authenticatedUser).value,
        put(authenticated(authenticatedUser.id)),
      )
    })

    it('handles not re-authenticated error', () => {
      const iterator = reAuthenticateEffect()

      assert.deepEqual(
        iterator.next().value,
        call(get, '/me')
      )

      const error: Error = { name: 'Forbidden', message: 'forbidden' }

      assert.deepEqual(
        iterator.throw(error).value,
        put(notReAuthenticated())
      )
    })
  })
})