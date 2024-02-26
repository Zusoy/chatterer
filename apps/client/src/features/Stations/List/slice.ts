import { createSlice, type PayloadAction } from '@reduxjs/toolkit'
import { type Station } from 'models/station'
import { type Nullable } from 'utils'
import { type Selector } from 'app/store'

export enum StationsStatus {
  Fetching = 'Fetching',
  Received = 'Received',
  Error = 'Error'
}

export type State = {
  items: Station[]
  station: Nullable<string>
  status: StationsStatus
}

export const initialState: State = {
  items: [],
  station: null,
  status: StationsStatus.Fetching
}

const slice = createSlice({
  name: 'stations',
  initialState,
  reducers: {
    fetchAll: state => ({
      ...state,
      status: StationsStatus.Fetching,
    }),
    received: (state, action: PayloadAction<Station[]>) => ({
      ...state,
      items: action.payload,
      status: StationsStatus.Received,
      station: action.payload.length > 0 ? action.payload[0].id : null
    }),
    upsertMany: (state, action: PayloadAction<Station[]>) => ({
      ...state,
      items: [
        ...state.items,
        ...action.payload
      ]
    }),
    changeStation: (state, action: PayloadAction<Station['id']>) => ({
      ...state,
      station: state.items.find(station => station.id === action.payload)?.id || null,
    }),
    error: state => ({
      ...state,
      status: StationsStatus.Error,
    })
  }
})

export const {
  fetchAll,
  received,
  changeStation,
  error,
  upsertMany
} = slice.actions

export const selectStations: Selector<Station[]> = state =>
  state.stations.items

export const selectIsFetching: Selector<boolean> = state =>
  state.stations.status === StationsStatus.Fetching

export const selectCurrentStationId: Selector<Nullable<string>> = state =>
  state.stations.station

export default slice
