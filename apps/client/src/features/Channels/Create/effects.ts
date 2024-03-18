import { type PayloadAction } from '@reduxjs/toolkit'
import { type Channel } from 'models/channel'
import { create, created, error, type CreatePayload } from 'features/Channels/Create/slice'
import { call, put, takeLatest } from 'redux-saga/effects'
import { post } from 'services/api'

export function* createChannelEffect(action: PayloadAction<CreatePayload>): Generator {
  try {
    const id = action.payload.stationId
    const channel = (yield call(post, `/station/${id}/channels`, action.payload)) as Channel
    yield put(created(channel))
  } catch (e) {
    yield put(error())
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(create, createChannelEffect)
}
