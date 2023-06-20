import assert from 'assert'
import { postMessageEffect } from 'features/Messages/Create/effects'
import { post, posted, error } from 'features/Messages/Create/slice'
import { post as httpPost } from 'services/api'
import { call, put } from 'redux-saga/effects'

describe('Effects/Messages/Create', () => {
  describe('PostMessage', () => {
    it('handles message posting', () => {
      const action = post({ channelId: 'channelId', content: 'Hello World !' })
      const iterator = postMessageEffect(action)

      assert.deepEqual(
        iterator.next().value,
        call(httpPost, '/channel/channelId/messages', { content: 'Hello World !' })
      )

      assert.deepEqual(
        iterator.next().value,
        put(posted())
      )
    })

    it('handles posting error', () => {
      const action = post({ channelId: 'channelId', content: 'Hello World !' })
      const iterator = postMessageEffect(action)

      assert.deepEqual(
        iterator.next().value,
        call(httpPost, '/channel/channelId/messages', { content: 'Hello World !' })
      )

      const errorMock: Error = { name: 'error', message: 'test' }

      assert.deepEqual(
        iterator.throw(errorMock).value,
        put(error())
      )
    })
  })
})
