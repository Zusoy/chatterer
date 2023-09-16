import { call, put, takeLatest } from 'redux-saga/effects'
import { PayloadAction } from '@reduxjs/toolkit'
import { JoinPayload, join, joined, error } from 'features/Stations/Join/slice'
import { post } from 'services/api'
import { IStation } from 'models/station'

export function* joinStationEffect(action: PayloadAction<JoinPayload>): Generator {
  const { token } = action.payload

  try {
    const targetStation = (yield call(post, '/stations/join', { token })) as IStation

    yield put(joined())
  } catch (e) {
    yield put(error())
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(join, joinStationEffect)
}
