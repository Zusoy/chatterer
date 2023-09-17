import { createSlice } from '@reduxjs/toolkit'
import { Nullable } from 'utils'
import { IUser } from 'models/user'
import { Selector } from 'app/store'
import { authenticated } from 'features/Me/Authentication/slice'

interface State {
  id: Nullable<IUser['id']>
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

export const selectAuthenticatedUserId: Selector<Nullable<IUser['id']>> =
  state => state.me.id

export default slice
