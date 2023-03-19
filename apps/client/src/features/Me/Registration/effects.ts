import { takeEvery, call, put } from 'redux-saga/effects';
import { post } from 'services/api';
import { error } from 'services/logger';
import { User } from 'models/User';
import registration, { RegistrationPayload } from 'features/Me/Registration/slice';

export function* register({ payload }: { payload: RegistrationPayload }): Generator {
  try {
    const user = (yield call(post, 'register', payload)) as User;

    yield put(registration.actions.registered(user));
  } catch (e) {
    error(e);
    yield put(registration.actions.error());
  }
}

export default function* rootSaga(): Generator {
  yield takeEvery(registration.actions.register, register);
}
