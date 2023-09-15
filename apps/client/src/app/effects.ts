import { all, fork } from 'redux-saga/effects'
import authentication from 'features/Me/Authentication/effects'
import stationsList from 'features/Stations/List/effects'
import channelsList from 'features/Channels/List/effects'

const effects = function* (): Generator {
  yield all([
    fork(authentication),
    fork(stationsList),
    fork(channelsList)
  ])
}

export default effects
