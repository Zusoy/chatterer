import { fetchAll, received, error } from 'features/Stations/slice'
import { Station } from 'models/station'
import { call, put, takeLatest } from 'redux-saga/effects'
import { get } from 'services/api'

export function* fetchAllEffect(): Generator {
  try {
    const items = (yield call(get, '/stations')) as Station[]
    yield put(received(items))
  } catch (e) {
    yield put(error())
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(fetchAll, fetchAllEffect)
}
