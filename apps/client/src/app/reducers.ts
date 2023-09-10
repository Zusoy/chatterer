import { combineReducers } from 'redux'
import authentication from 'features/Me/Authentication/slice'
import me from 'features/Me/slice'

export default combineReducers({
  authentication: authentication.reducer,
  me: me.reducer
})
