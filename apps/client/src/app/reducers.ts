import { combineReducers } from 'redux'
import authentication from 'features/Me/Authentication/slice'
import me from 'features/Me/slice'
import stationsList from 'features/Stations/List/slice'
import channelsList from 'features/Channels/List/slice'
import messenger from 'features/Messages/Messenger/slice'

export default combineReducers({
  authentication: authentication.reducer,
  me: me.reducer,
  stations: stationsList.reducer,
  channels: channelsList.reducer,
  messenger: messenger.reducer
})
