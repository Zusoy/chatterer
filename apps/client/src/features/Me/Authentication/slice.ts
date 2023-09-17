import { createSlice, PayloadAction } from '@reduxjs/toolkit'
import { Selector } from 'app/store'
import { IUser } from 'models/user'

export enum AuthenticationStatus {
  Anonymous = 'Anonymous',
  Authenticating = 'Authenticating',
  ReAuthenticating = 'ReAuthenticating',
  Authenticated = 'Authenticated',
  Error = 'Error'
}

export interface AuthenticationPayload {
  readonly username: string
  readonly password: string
}

interface State {
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
    authenticated: (state, _payload: PayloadAction<IUser['id']>) => ({
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
