import { call, put, takeLatest } from 'redux-saga/effects'
import { logout, loggedOut, error } from 'features/Me/Logout/slice'
import { remove } from 'services/storage'

export function* logoutEffect(): Generator {
  try {
    yield (call(remove, 'token'))
    yield put(loggedOut())

    window.location.reload()
  } catch (e) {
    yield put(error())
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(logout, logoutEffect)
}
