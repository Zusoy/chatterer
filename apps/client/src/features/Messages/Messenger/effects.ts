import { type PayloadAction } from '@reduxjs/toolkit';
import { type PostPayload, posted, error, post } from 'features/Messages/Messenger/slice'
import { post as httpPost } from 'services/api'
import { call, put, takeEvery } from 'redux-saga/effects'

export function* postMessageEffect(action: PayloadAction<PostPayload>): Generator {
  const { content, channelId } = action.payload

  try {
    yield (call(httpPost, `/channel/${channelId}/messages`, { content }))
    yield put(posted())
  } catch (e) {
    yield put(error())
  }
}

export default function* rootSaga(): Generator {
  yield takeEvery(post, postMessageEffect)
}
