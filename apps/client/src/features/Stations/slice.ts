import { createSlice, PayloadAction } from '@reduxjs/toolkit'
import { Station } from 'models/station'
import { Selector } from 'app/store'
import { Nullable } from 'utils'

export enum StationsStatus {
  Fetching = 'Fetching',
  Received = 'Received',
  Error = 'Error'
}

export interface State {
  items: Station[]
  station: Nullable<Station>
  status: StationsStatus
}

export const initialState: State = {
  items: [],
  station: null,
  status: StationsStatus.Fetching,
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
  upsertMany,
} = slice.actions

export const selectStations: Selector<Station[]> = state =>
  state.stations.items

export const selectIsFetching: Selector<boolean> = state =>
  state.stations.status === StationsStatus.Fetching

export const selectCurrentStation: Selector<Nullable<Station>> = state =>
  state.stations.station

export default slice
