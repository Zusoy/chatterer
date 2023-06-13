import { call, put, takeEvery } from 'redux-saga/effects'
import { post, posted, error, PostPayload } from 'features/Message/slice'
import { PayloadAction } from '@reduxjs/toolkit'
import { post as httpPost } from 'services/api'

export function* postMessageEffect(action: PayloadAction<PostPayload>): Generator {
  const { content, channelId } = action.payload
  try {
    yield (call(httpPost, `/channel/${channelId}/messages`, { content }))

    yield put(posted())
  } catch(e) {
    yield put(error())
  }
}

export default function* rootSaga(): Generator {
  yield takeEvery(post, postMessageEffect)
}
