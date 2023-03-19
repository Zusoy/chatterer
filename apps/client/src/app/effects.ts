import { all, fork } from 'redux-saga/effects';
import authentication from 'features/Me/Authentication/effects';
import registration from 'features/Me/Registration/effects';
import stationsList from 'features/StationsSidebar/List/effects';

const effects = function* (): Generator {
  yield all([
    fork(authentication),
    fork(registration),
    fork(stationsList),
  ])
}

export default effects;
