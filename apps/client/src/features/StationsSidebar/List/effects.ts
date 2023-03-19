import { takeEvery, call, put } from 'redux-saga/effects';
import { get } from 'services/api';
import { Station } from 'models/Station';
import { error } from 'services/logger';
import stations from 'features/StationsSidebar/slice';

export function* fetchList(): Generator {
  try {
    const items = yield (call(get, 'stations'));

    yield put(stations.actions.received(items as Station[]));
  } catch (e) {
    error(e);
    yield put(stations.actions.error());
  }
}

export default function* rootSaga(): Generator {
  yield takeEvery(stations.actions.fetchList, fetchList);
}
