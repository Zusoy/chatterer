import assert from 'assert'
import { postMessageEffect } from 'features/Messages/Messenger/effects'
import { post, posted, error } from 'features/Messages/Messenger/slice'
import { post as httpPost } from 'services/api'
import { call, put } from 'redux-saga/effects'

describe('Effects/Messages/Messenger', () => {
  describe('PostMessage', () => {
    it('handles message posting', () => {
      const action = post({ channelId: 'channelId', content: 'Hello World !' })
      const effect = postMessageEffect(action)

      assert.deepEqual(
        effect.next().value,
        call(httpPost, '/channel/channelId/messages', { content: 'Hello World !' })
      )

      assert.deepEqual(
        effect.next().value,
        put(posted())
      )
    })

    it('handles posting error', () => {
      const action = post({ channelId: 'channelId', content: 'Hello World !' })
      const effect = postMessageEffect(action)

      assert.deepEqual(
        effect.next().value,
        call(httpPost, '/channel/channelId/messages', { content: 'Hello World !' })
      )

      const errorMock: Error = { name: 'error', message: 'test' }

      assert.deepEqual(
        effect.throw(errorMock).value,
        put(error())
      )
    })
  })
})
