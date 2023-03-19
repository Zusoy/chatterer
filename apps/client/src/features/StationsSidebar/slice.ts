import { createSlice, PayloadAction } from '@reduxjs/toolkit';
import { Station } from 'models/Station';
import { Selector } from 'app/store';

export enum FetchStatus {
  Fetching = 'Fetching',
  Fetched = 'Fetched',
  UnknownError = 'UnknownError'
}

interface State {
  current: Station|null;
  items: Station[];
  status: FetchStatus;
}

export const initialState: State = ({
  current: null,
  items: [],
  status: FetchStatus.Fetching,
});

const slice = createSlice({
  name: 'stations',
  initialState,
  reducers: {
    fetchList: state => state,
    received: (state, action: PayloadAction<Station[]>) => ({
      ...state,
      items: action.payload,
    }),
    select: (state, action: PayloadAction<Station['id']>) => ({
      ...state,
      current: state.items.find(station => station.id === action.payload) || null,
    }),
    error: state => ({
      ...state,
      status: FetchStatus.UnknownError,
    }),
  }
});

export const selectStations: Selector<Station[]> = state =>
  state.stations.items;

export const selectCurrentStation: Selector<Station|null> = state =>
  state.stations.current;

export default slice;
