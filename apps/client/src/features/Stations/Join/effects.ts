import { call, put, takeLatest } from 'redux-saga/effects'
import { PayloadAction } from '@reduxjs/toolkit'
import { JoinPayload, join, joined, error } from 'features/Stations/Join/slice'
import { post } from 'services/api'
import { success as notificationSuccess, error as notificationError } from 'services/notification'
import { Station } from 'models/station'

export function* joinStationEffect(action: PayloadAction<JoinPayload>): Generator {
  const { token } = action.payload

  try {
    const targetStation = (yield call(post, '/stations/join', { token })) as Station

    yield put(joined())
    yield call(notificationSuccess, `Welcome to the station ${ targetStation.name } !`)
  } catch (e) {
    yield put(error())
    yield call(notificationError, 'Failed to join station')
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(join, joinStationEffect)
}
