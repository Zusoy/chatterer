import { all, fork } from 'redux-saga/effects'
import authentication from 'features/Me/Authentication/effects'
import stationsList from 'features/Stations/List/effects'
import channelsList from 'features/Channels/List/effects'
import messagesList from 'features/Messages/List/effects'

const effects = function* (): Generator {
  yield all([
    fork(authentication),
    fork(stationsList),
    fork(channelsList),
    fork(messagesList)
  ])
}

export default effects
