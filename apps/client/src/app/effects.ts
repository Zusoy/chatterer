import { all, fork } from 'redux-saga/effects'
import authentication from 'features/Me/Authentication/effects'
import stations from 'features/Stations/effects'
import channels from 'features/Channels/effects'

const effects = function* (): Generator {
  yield all([
    fork(authentication),
    fork(stations),
    fork(channels),
  ])
}

export default effects
