import { type PayloadAction } from '@reduxjs/toolkit'
import { type Station } from 'models/station'
import { type Channel } from 'models/channel'
import { call, put, takeLatest } from 'redux-saga/effects'
import { fetchAll, received, error } from 'features/Channels/slice'
import { get } from 'services/api'

export function* fetchAllEffect(action: PayloadAction<Station['id']>): Generator {
  const id = action.payload

  try {
    const items = (yield call(get, `/station/${id}/channels`)) as Channel[]
    yield put(received(items))
  } catch (e) {
    yield put(error())
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(fetchAll, fetchAllEffect)
}
