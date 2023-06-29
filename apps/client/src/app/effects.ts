import { all, fork } from 'redux-saga/effects'
import authentication from 'features/Me/Authentication/effects'
import logout from 'features/Me/Logout/effects'
import stations from 'features/Stations/List/effects'
import channels from 'features/Channels/List/effects'
import messages from 'features/Messages/List/effects'
import message from 'features/Messages/Create/effects'
import join from 'features/Stations/Join/effects'

const effects = function* (): Generator {
  yield all([
    fork(authentication),
    fork(logout),
    fork(stations),
    fork(channels),
    fork(messages),
    fork(message),
    fork(join),
  ])
}

export default effects
