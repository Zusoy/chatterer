import { all, fork } from 'redux-saga/effects'
import authentication from 'features/Me/Authentication/effects'
import logout from 'features/Me/Logout/effects'
import stations from 'features/Stations/List/effects'
import createStation from 'features/Stations/Create/effects'
import channels from 'features/Channels/List/effects'
import createChannel from 'features/Channels/Create/effects'
import messages from 'features/Messages/List/effects'
import messenger from 'features/Messages/Messenger/effects'

const effects = function* (): Generator {
  yield all([
    fork(authentication),
    fork(logout),
    fork(stations),
    fork(createStation),
    fork(channels),
    fork(createChannel),
    fork(messages),
    fork(messenger),
  ])
}

export default effects
