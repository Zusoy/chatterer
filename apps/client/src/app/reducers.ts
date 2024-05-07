import { combineReducers } from 'redux'
import authentication from 'features/Me/Authentication/slice'
import me from 'features/Me/slice'
import logout from 'features/Me/Logout/slice'
import stations from 'features/Stations/slice'
import createStation from 'features/Stations/Create/slice'
import channels from 'features/Channels/slice'
import createChannel from 'features/Channels/Create/slice'
import messages from 'features/Messages/List/slice'
import messenger from 'features/Messages/Messenger/slice'

export default combineReducers({
  authentication: authentication.reducer,
  me: me.reducer,
  logout: logout.reducer,
  stations: stations.reducer,
  createStation: createStation.reducer,
  channels: channels.reducer,
  createChannel: createChannel.reducer,
  messages: messages.reducer,
  messenger: messenger.reducer,
})
