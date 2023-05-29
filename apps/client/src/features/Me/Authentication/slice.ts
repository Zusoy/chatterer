import { createSlice, PayloadAction } from '@reduxjs/toolkit'
import { Selector } from 'app/store'
import { User } from 'models/user'

export enum AuthenticationStatus {
  Anonymous = 'Anonymous',
  Authenticating = 'Authenticating',
  ReAuthenticating = 'ReAuthenticating',
  Authenticated = 'Authenticated',
  Error = 'Error'
}

export interface AuthenticationPayload {
  username: string
  password: string
}

interface State {
  status: AuthenticationStatus
}

const initialState: State = ({
  status: AuthenticationStatus.Anonymous
})

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

export const selectIsAuthenticating: Selector<boolean> = state =>
  state.authentication.status === AuthenticationStatus.Authenticating

export const selectIsReAuthenticating: Selector<boolean> = state =>
  state.authentication.status === AuthenticationStatus.ReAuthenticating

export default slice
