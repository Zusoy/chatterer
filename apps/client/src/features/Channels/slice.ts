import { createSlice, PayloadAction } from '@reduxjs/toolkit'
import { Channel } from 'models/channel'
import { Nullable } from 'utils'
import { Selector } from 'app/store'

export enum ChannelsStatus {
  Fetching = 'Fetching',
  Received = 'Received',
  Error = 'Error'
}

interface State {
  items: Channel[]
  channel: Nullable<Channel>
  status: ChannelsStatus
}

const initialState: State = {
  items: [],
  channel: null,
  status: ChannelsStatus.Fetching,
}

const slice = createSlice({
  name: 'channels',
  initialState,
  reducers: {
    fetchAll: (state, _action: PayloadAction<Channel['id']>) => ({
      ...state,
      status: ChannelsStatus.Fetching,
    }),
    received: (state, action: PayloadAction<Channel[]>) => ({
      ...state,
      items: action.payload,
      status: ChannelsStatus.Received,
    }),
    error: state => ({
      ...state,
      status: ChannelsStatus.Error,
    }),
  }
})

export const {
  fetchAll,
  received,
  error,
} = slice.actions

export const selectItems: Selector<Channel[]> = state =>
  state.channels.items

export const selectIsFetching: Selector<boolean> = state =>
  state.channels.status === ChannelsStatus.Fetching

export default slice
