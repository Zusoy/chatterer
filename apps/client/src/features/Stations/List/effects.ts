import { fetchAll, received, error } from 'features/Stations/List/slice'
import { IStation } from 'models/station'
import { call, put, takeLatest } from 'redux-saga/effects'
import { get } from 'services/api'

export function* fetchAllEffect(): Generator {
  try {
    const items = (yield call(get, '/stations')) as IStation[]
    yield put(received(items))
  } catch (e) {
    yield put(error())
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(fetchAll, fetchAllEffect)
}
