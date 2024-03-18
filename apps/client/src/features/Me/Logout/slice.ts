import { createSlice } from '@reduxjs/toolkit'
import { type Selector } from 'app/store'

export enum LogoutStatus {
  Initial = 'Initial',
  LoggingOut = 'LoggingOut',
  Error = 'Error'
}

export type State = {
  status: LogoutStatus
}

export const initialState: State = {
  status: LogoutStatus.Initial
}

const slice = createSlice({
  name: 'logout',
  initialState,
  reducers: {
    logout: state => ({
      ...state,
      state: LogoutStatus.LoggingOut
    }),
    error: state => ({
      ...state,
      status: LogoutStatus.Error
    })
  }
})

export const {
  logout,
  error
} = slice.actions

export const selectIsLoggingOut: Selector<boolean> = state =>
  state.logout.status === LogoutStatus.LoggingOut

export default slice
