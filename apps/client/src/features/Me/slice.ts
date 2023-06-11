import { createSlice } from '@reduxjs/toolkit'
import { User } from 'models/user'
import { Selector } from 'app/store'
import { Nullable } from 'utils'
import authentication from 'features/Me/Authentication/slice'

interface State {
  id: Nullable<User['id']>
}

const initialState: State = {
  id: null,
}

const slice = createSlice({
  name: 'me',
  initialState,
  reducers: {
  },
  extraReducers: builder => {
    builder
      .addCase(authentication.actions.authenticated, (state, { payload: id }) => ({
        ...state,
        id
      }))
  }
})

export const selectIsAuth: Selector<boolean> = state =>
  state.me.id !== null

export const selectAuthenticatedUserId: Selector<User['id'] | null> =
  state => state.me.id

export default slice
