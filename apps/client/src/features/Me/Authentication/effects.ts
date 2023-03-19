import { error } from 'services/logger';
import { takeEvery, call, put } from 'redux-saga/effects';
import { post, get } from 'services/api';
import { User } from 'models/User';
import authentication, { AuthenticatePayload } from 'features/Me/Authentication/slice';

export function* authenticate({ payload } : { payload: AuthenticatePayload }): Generator {
  try {
    const me = (yield call(post, 'auth', payload)) as User;

    yield put(authentication.actions.authenticated(me));
  } catch (e) {
    error(e);
    yield put(authentication.actions.error());
  }
}

export function* reAuthenticate(): Generator {
  try {
    const me = (yield call(get, 'me')) as User;

    yield put(authentication.actions.authenticated(me));
  } catch (e) {
    error(e);
    yield put(authentication.actions.notReAuthenticated());
  }
}

export default function* rootSaga(): Generator {
  yield takeEvery(authentication.actions.authenticate, authenticate);
  yield takeEvery(authentication.actions.reAuthenticate, reAuthenticate);
}
