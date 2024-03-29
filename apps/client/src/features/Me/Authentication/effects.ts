import { PayloadAction } from '@reduxjs/toolkit'
import { call, takeLatest, put } from 'redux-saga/effects'
import { get, post } from 'services/api'
import { IUser } from 'models/user'
import { save } from 'services/storage'
import {
  AuthenticationPayload,
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
    yield put(error())
  }
}

export function* reAuthenticateEffect(): Generator {
  try {
    const me = (yield call(get, '/me')) as IUser
    yield put(authenticated(me.id))
  } catch (e) {
    yield put(notReAuthenticated())
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(authenticate, authenticateEffect)
  yield takeLatest(reAuthenticate, reAuthenticateEffect)
}
