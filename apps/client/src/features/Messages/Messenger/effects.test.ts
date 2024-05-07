import { describe, test, expect } from 'vitest'
import { post, posted, error } from 'features/Messages/Messenger/slice'
import { post as httpPost, ApiErrorResponse } from 'services/api'
import { call, put } from 'redux-saga/effects'
import { postMessageEffect } from 'features/Messages/Messenger/effects'
import { channelMock } from 'test-utils'

describe('Effects/Messages/Messenger', () => {
  describe('PostMessage', () => {
    test('it handles message posting', () => {
      const channelId = channelMock.id
      const action = post({ content: 'Hello World !', channelId })
      const effect = postMessageEffect(action)

      expect(effect.next().value)
        .toStrictEqual(call(httpPost, `/channel/${channelId}/messages`, { content: 'Hello World !' }))

      expect(effect.next().value)
        .toStrictEqual(put(posted()))
    })

    test('it handles error', () => {
      const channelId = channelMock.id
      const action = post({ content: 'Hello World !', channelId })
      const effect = postMessageEffect(action)

      expect(effect.next().value)
        .toStrictEqual(call(httpPost, `/channel/${channelId}/messages`, { content: 'Hello World !' }))

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
