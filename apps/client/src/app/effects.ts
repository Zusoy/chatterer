import { all, fork } from 'redux-saga/effects'
import authentication from 'features/Me/Authentication/effects'
import stations from 'features/Stations/effects'
import channels from 'features/Channels/effects'
import messages from 'features/Messages/effects'
import message from 'features/Message/effects'

const effects = function* (): Generator {
  yield all([
    fork(authentication),
    fork(stations),
    fork(channels),
    fork(messages),
    fork(message),
  ])
}

export default effects
