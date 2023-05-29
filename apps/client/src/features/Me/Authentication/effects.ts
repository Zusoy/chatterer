import { PayloadAction } from '@reduxjs/toolkit'
import { call, takeLatest, put } from 'redux-saga/effects'
import { get, post } from 'services/api'
import { User } from 'models/user'
import authentication, { AuthenticationPayload } from 'features/Me/Authentication/slice'

export function* authenticate(action: PayloadAction<AuthenticationPayload>): Generator {
  const payload = action.payload

  try {
    const user = (yield call(post, '/auth', payload)) as User

    yield put(authentication.actions.authenticated(user.id))
  } catch (e) {
    console.error(e)
    yield put(authentication.actions.error())
  }
}

export function* reAuthenticate(): Generator {
  try {
    const me = (yield call(get, '/me')) as User
    yield put(authentication.actions.authenticated(me.id))
  } catch (e) {
    console.error(e)
    yield put(authentication.actions.notReAuthenticated())
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(authentication.actions.authenticate, authenticate)
  yield takeLatest(authentication.actions.reAuthenticate, reAuthenticate)
}
