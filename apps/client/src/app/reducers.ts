import { combineReducers } from 'redux'
import me from 'features/Me/slice'
import authentication from 'features/Me/Authentication/slice'
import logout from 'features/Me/Logout/slice'
import stations from 'features/Stations/List/slice'
import channels from 'features/Channels/List/slice'
import messages from 'features/Messages/List/slice'
import message from 'features/Messages/Create/slice'

export default combineReducers({
  me: me.reducer,
  authentication: authentication.reducer,
  logout: logout.reducer,
  stations: stations.reducer,
  channels: channels.reducer,
  messages: messages.reducer,
  message: message.reducer,
})
