import { Selector } from 'app/store';
import { createSlice, PayloadAction } from '@reduxjs/toolkit';
import { User } from 'models/User';

export enum AuthenticationStatus {
  Initial = 'Initial',
  Authenticating = 'Authenticating',
  Authenticated = 'Authenticated',
  ReAuthenticating = 'ReAuthenticating',
  Anonymous = 'Anonymous',
  UnknownError = 'UnknownError',
}

interface State {
  status: AuthenticationStatus;
}

export interface AuthenticatePayload {
  username: string;
  password: string;
}

const initialState: State = {
  status: AuthenticationStatus.Initial,
}

const slice = createSlice({
  name: 'authentication',
  initialState,
  reducers: {
    authenticate: (state, _action: PayloadAction<AuthenticatePayload>) => ({
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
    authenticated: (state, _action: PayloadAction<User>) => ({
      ...state,
      status: AuthenticationStatus.Authenticated,
    }),
    error: state => ({
      ...state,
      status: AuthenticationStatus.UnknownError,
    }),
  }
})

export const selectIsAuthenticating: Selector<boolean> = state =>
  state.authentication.status === AuthenticationStatus.Authenticating;

export const selectIsReAuthenticating: Selector<boolean> = state =>
  state.authentication.status === AuthenticationStatus.ReAuthenticating;

export const selectIsError: Selector<boolean> = state =>
  state.authentication.status === AuthenticationStatus.UnknownError;

export default slice;
