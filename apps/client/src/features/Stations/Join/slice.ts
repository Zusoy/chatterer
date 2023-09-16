import { createSlice, PayloadAction } from '@reduxjs/toolkit'

export enum JoinStatus {
  Initial = 'Initial',
  Joining = 'Joining',
  Error = 'Error'
}

export interface JoinPayload {
  token: string
}

interface State {
  status: JoinStatus
}

export const initialState: State = {
  status: JoinStatus.Initial
}

const slice = createSlice({
  name: 'join',
  initialState,
  reducers: {
    join: (state, _action: PayloadAction<JoinPayload>) => ({
      ...state,
      status: JoinStatus.Joining,
    }),
    joined: state => ({
      ...state,
      status: JoinStatus.Initial,
    }),
    error: state => ({
      ...state,
      status: JoinStatus.Error,
    }),
  }
})

export const {
  join,
  joined,
  error
} = slice.actions

export default slice
