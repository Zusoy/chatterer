import { combineReducers } from 'redux'
import me from 'features/Me/slice'
import authentication from 'features/Me/Authentication/slice'
import stations from 'features/Stations/slice'
import channels from 'features/Channels/slice'
import messages from 'features/Messages/slice'

export default combineReducers({
  me: me.reducer,
  authentication: authentication.reducer,
  stations: stations.reducer,
  channels: channels.reducer,
  messages: messages.reducer,
})
