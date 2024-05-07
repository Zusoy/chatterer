import { create, created, error, type CreatePayload } from 'features/Stations/Create/slice'
import { put, call, takeLatest } from 'redux-saga/effects'
import { post } from 'services/api'
import { type PayloadAction } from '@reduxjs/toolkit'
import { type Station } from 'models/station'

export function* createStationEffect(action: PayloadAction<CreatePayload>): Generator {
  try {
    const item = (yield call(post, '/stations', action.payload)) as Station
    yield put(created(item))
  } catch (e) {
    yield put(error())
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(create, createStationEffect)
}
