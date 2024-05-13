import { call, put, takeLatest } from 'redux-saga/effects'
import { remove } from 'services/storage'
import { logout, loggedOut, error } from 'features/Me/Logout/slice'

export function* logoutEffect(): Generator {
  try {
    yield (call(remove, 'token'))
    yield put(loggedOut())
  } catch (e) {
    yield put(error())
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(logout, logoutEffect)
}
