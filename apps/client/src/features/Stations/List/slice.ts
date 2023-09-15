import { createSlice, PayloadAction } from '@reduxjs/toolkit'
import { IStation } from 'models/station'
import { Nullable } from 'utils'
import { Selector } from 'app/store'

export enum StationsStatus {
  Fetching = 'Fetching',
  Received = 'Received',
  Error = 'Error'
}

export interface State {
  items: IStation[]
  station: Nullable<IStation>
  status: StationsStatus
}

export const initialState: State = {
  status: StationsStatus.Fetching,
  station: null,
  items: []
}

const slice = createSlice({
  name: 'stations',
  initialState,
  reducers: {
    fetchAll: state => ({
      ...state,
      status: StationsStatus.Fetching,
    }),
    received: (state, action: PayloadAction<IStation[]>) => ({
      ...state,
      items: action.payload,
      status: StationsStatus.Received,
    }),
    upsertMany: (state, action: PayloadAction<IStation[]>) => ({
      ...state,
      items: [
        ...state.items,
        ...action.payload
      ]
    }),
    changeStation: (state, action: PayloadAction<IStation['id']>) => ({
      ...state,
      station: state.items.find(station => station.id === action.payload) || null,
    }),
    error: state => ({
      ...state,
      status: StationsStatus.Error,
    }),
  }
})

export const {
  fetchAll,
  received,
  changeStation,
  error,
  upsertMany
} = slice.actions

export const selectStations: Selector<IStation[]> = state =>
  state.stations.items

export const selectIsFetching: Selector<boolean> = state =>
  state.stations.status === StationsStatus.Fetching

export const selectCurrentStation: Selector<Nullable<IStation>> = state =>
  state.stations.station

export default slice
