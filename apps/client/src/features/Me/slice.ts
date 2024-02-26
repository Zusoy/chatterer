import { createSlice } from '@reduxjs/toolkit'
import { authenticated } from 'features/Me/Authentication/slice'
import { type Nullable } from 'utils'
import { type Selector } from 'app/store'
import { type User } from 'models/user'

type State = {
  id: Nullable<User['id']>
}

const initialState: State = {
  id: null
}

const slice = createSlice({
  name: 'me',
  initialState,
  reducers: {},
  extraReducers: builder => {
    builder
      .addCase(authenticated, (state, { payload: id }) => ({
        ...state,
        id
      }))
  }
})

export const selectIsAuth: Selector<boolean> = state =>
  state.me.id !== null

export const selectAuthenticatedUserId: Selector<State['id']> =
  state => state.me.id

export default slice
