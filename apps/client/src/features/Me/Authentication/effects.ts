import { type PayloadAction} from '@reduxjs/toolkit'
import { type User } from 'models/user'
import { call, takeLatest, put } from 'redux-saga/effects'
import { get, post } from 'services/api'
import { save } from 'services/storage'
import {
  type AuthenticationPayload,
  authenticate,
  authenticated,
  notReAuthenticated,
  reAuthenticate,
  error
} from 'features/Me/Authentication/slice'

export function* authenticateEffect(action: PayloadAction<AuthenticationPayload>): Generator {
  const payload = action.payload

  try {
    const { token } = (yield call(post, '/auth', payload)) as { token: string }
    yield call(save, 'token', token)
  } catch (e) {
    console.log(e)
    yield put(error())
  }
}

export function* reAuthenticateEffect(): Generator {
  try {
    const me = (yield call(get, '/me')) as User
    yield put(authenticated(me.id))
  } catch (e) {
    yield put(notReAuthenticated())
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(authenticate, authenticateEffect)
  yield takeLatest(reAuthenticate, reAuthenticateEffect)
}
