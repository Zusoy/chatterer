import { call, put, takeLatest } from 'redux-saga/effects'
import { PayloadAction } from '@reduxjs/toolkit'
import { JoinPayload, join, joined, error } from 'features/Stations/Join/slice'
import { post } from 'services/api'

export function* joinStationEffect(action: PayloadAction<JoinPayload>): Generator {
  const { token } = action.payload

  try {
    yield call(post, '/stations/join', { token })

    yield put(joined())
  } catch (e) {
    yield put(error())
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(join, joinStationEffect)
}
