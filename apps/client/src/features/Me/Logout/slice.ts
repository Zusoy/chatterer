import { createSlice } from '@reduxjs/toolkit'

export enum LogoutStatus {
  Initial = 'Initial',
  LoggingOut = 'LoggingOut',
  LoggedOut = 'LoggedOut',
  Error = 'Error'
}

export interface State {
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
      status: LogoutStatus.LoggingOut,
    }),
    loggedOut: state => ({
      ...state,
      status: LogoutStatus.LoggedOut,
    }),
    error: state => ({
      ...state,
      status: LogoutStatus.Error,
    }),
  }
})

export const {
  logout,
  loggedOut,
  error,
} = slice.actions

export default slice
