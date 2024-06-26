import { createSlice, type PayloadAction } from '@reduxjs/toolkit'
import { type Selector } from 'app/store'
import { type User } from 'models/user'

export enum AuthenticationStatus {
  Anonymous = 'Anonymous',
  Authenticating = 'Authenticating',
  ReAuthenticating = 'ReAuthenticating',
  Authenticated = 'Authenticated',
  Error = 'Error'
}

export type AuthenticationPayload = {
  username: string
  password: string
}

type State = {
  status: AuthenticationStatus
}

const initialState: State = {
  status: AuthenticationStatus.Anonymous
}

const slice = createSlice({
  name: 'authentication',
  initialState,
  reducers: {
    authenticate: (state, _payload: PayloadAction<AuthenticationPayload>) => ({
      ...state,
      status: AuthenticationStatus.Authenticating,
    }),
    reAuthenticate: state => ({
      ...state,
      status: AuthenticationStatus.ReAuthenticating,
    }),
    notReAuthenticated: state => ({
      ...state,
      status: AuthenticationStatus.Anonymous,
    }),
    authenticated: (state, _payload: PayloadAction<User['id']>) => ({
      ...state,
      status: AuthenticationStatus.Authenticated,
    }),
    error: state => ({
      ...state,
      status: AuthenticationStatus.Error,
    }),
  }
})

export const {
  authenticate,
  reAuthenticate,
  notReAuthenticated,
  authenticated,
  error
} = slice.actions

export const selectIsAuthenticating: Selector<boolean> = state =>
  state.authentication.status === AuthenticationStatus.Authenticating

export const selectIsReAuthenticating: Selector<boolean> = state =>
  state.authentication.status === AuthenticationStatus.ReAuthenticating

export default slice
