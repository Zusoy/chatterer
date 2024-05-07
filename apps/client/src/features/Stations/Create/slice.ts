import { createSlice, type PayloadAction } from '@reduxjs/toolkit'
import { type Nullable } from 'utils'
import { type Station } from 'models/station'
import { type Selector } from 'app/store'

export enum CreateStatus {
  Initial = 'Initial',
  Creating = 'Creating',
  Created = 'Created',
  Error = 'Error'
}

export type CreatePayload = {
  name: string
  description: Nullable<string>
}

export type State = {
  status: CreateStatus
}

export const initialState: State = {
  status: CreateStatus.Initial
}

const slice = createSlice({
  name: 'stationCreate',
  initialState,
  reducers: {
    create: (state, _action: PayloadAction<CreatePayload>) => ({
      ...state,
      status: CreateStatus.Creating
    }),
    created: (state, _action: PayloadAction<Station>) => ({
      ...state,
      status: CreateStatus.Created,
    }),
    error: state => ({
      ...state,
      status: CreateStatus.Error,
    }),
    clear: _state => initialState
  }
})

export const {
  create,
  created,
  error,
  clear
} = slice.actions

export const selectIsCreating: Selector<boolean> = state =>
  state.createStation.status === CreateStatus.Creating

export const selectIsCreated: Selector<boolean> = state =>
  state.createStation.status === CreateStatus.Created

export const selectIsError: Selector<boolean> = state =>
  state.createStation.status === CreateStatus.Error

export default slice
