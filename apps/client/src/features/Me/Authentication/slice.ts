import { createSlice } from '@reduxjs/toolkit'

export enum AuthenticationStatus {
  Anonymous = 'Anonymous',
  Authenticating = 'Authenticating',
  ReAuthenticating = 'ReAuthenticating',
  Authenticated = 'Authenticated',
  Error = 'Error'
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
  }
})

export default slice
