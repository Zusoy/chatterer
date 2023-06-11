import { PayloadAction } from '@reduxjs/toolkit'
import { call, put, takeLatest } from 'redux-saga/effects'
import { fetchAll, received, error } from 'features/Messages/slice'
import { get } from 'services/api'
import { Message } from 'models/message'

export function* fetchAllEffect(action: PayloadAction<string>): Generator {
  const id = action.payload

  try {
    const messages = (yield call(get, `/channel/${id}/messages`)) as Message[]

    yield put(received(messages))
  } catch (e) {
    console.error(e)
    yield put(error)
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(fetchAll, fetchAllEffect)
}
