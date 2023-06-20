import { call, put, takeLatest } from 'redux-saga/effects'
import { fetchAll, received, error } from 'features/Channels/List/slice'
import { get } from 'services/api'
import { PayloadAction } from '@reduxjs/toolkit'
import { Channel } from 'models/channel'

export function* fetchAllEffect(action: PayloadAction<string>): Generator {
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
