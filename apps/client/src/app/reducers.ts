import { combineReducers } from 'redux'
import me from 'features/Me/slice'
import authentication from 'features/Me/Authentication/slice'

export default combineReducers({
  me: me.reducer,
  authentication: authentication.reducer,
})
