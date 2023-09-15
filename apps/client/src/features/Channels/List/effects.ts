import { PayloadAction } from '@reduxjs/toolkit'
import { call, put, takeLatest } from 'redux-saga/effects'
import { fetchAll, received, error } from 'features/Channels/List/slice'
import { get } from 'services/api'
import { IStation } from 'models/station'
import { IChannel } from 'models/channel'

export function* fetchAllEffect(action: PayloadAction<IStation['id']>): Generator {
  const id = action.payload

  try {
    const items = (yield call(get, `/station/${id}/channels`)) as IChannel[]

    yield put(received(items))
  } catch (e) {
    yield put(error())
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(fetchAll, fetchAllEffect)
}
