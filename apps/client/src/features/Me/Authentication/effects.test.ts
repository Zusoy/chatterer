import assert from 'assert'
import { describe, test } from 'vitest'
import { authenticateEffect, reAuthenticateEffect } from 'features/Me/Authentication/effects'
import { authenticate, authenticated, notReAuthenticated, error } from 'features/Me/Authentication/slice'
import { call, put } from 'redux-saga/effects'
import { get, post, ApiErrorResponse } from 'services/api'
import { save } from 'services/storage'
import { userMock } from 'test-utils'

describe('Effects/Authentication', () => {
  describe('Authenticate', () => {
    test ('it handles authentication and token storage', () => {
      const action = authenticate({ username: 'test', password: 'test'})
      const effect = authenticateEffect(action)

      assert.deepEqual(
        effect.next().value,
        call(post, '/auth', { username: 'test', password: 'test'})
      )

      const mockedResponse = { token: 'auth_token' }

      assert.deepEqual(
        effect.next(mockedResponse).value,
        call(save, 'token', mockedResponse.token)
      )
    })

    test ('it handles error', () => {
      const action = authenticate({ username: 'test', password: 'test' })
      const effect = authenticateEffect(action)

      assert.deepEqual(
        effect.next().value,
        call(post, '/auth', { username: 'test', password: 'test'})
      )

      const mockedError = new ApiErrorResponse(
        403,
        '/auth',
        {
          code: 0,
          message: 'Forbidden',
          type: 'InvalidCredentials',
          extra: {}
        }
      )

      assert.deepEqual(
        effect.throw(mockedError).value,
        put(error())
      )
    })
  })

  describe('ReAuthenticate', () => {
    test ('it handles re-authentication', () => {
      const effect = reAuthenticateEffect()

      assert.deepEqual(
        effect.next().value,
        call(get, '/me')
      )

      const authenticatedUser = userMock

      assert.deepEqual(
        effect.next(authenticatedUser).value,
        put(authenticated(authenticatedUser.id))
      )
    })

    test ('it handles not re-authenticated error', () => {
      const effect = reAuthenticateEffect()

      assert.deepEqual(
        effect.next().value,
        call(get, '/me')
      )

      const mockedError = new ApiErrorResponse(
        403,
        '/auth',
        {
          code: 0,
          message: 'Forbidden',
          type: 'InvalidCredentials',
          extra: {}
        }
      )

      assert.deepEqual(
        effect.throw(mockedError).value,
        put(notReAuthenticated())
      )
    })
  })
})
