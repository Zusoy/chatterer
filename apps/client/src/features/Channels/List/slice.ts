import { createSlice, PayloadAction } from '@reduxjs/toolkit'
import { Nullable } from 'utils'
import { Selector } from 'app/store'
import { IStation } from 'models/station'
import { IChannel } from 'models/channel'
import { changeStation } from 'features/Stations/List/slice'

export enum ChannelsStatus {
  Initial = 'Initial',
  Fetching = 'Fetching',
  Received = 'Received',
  Error = 'Error'
}

export interface State {
  items: IChannel[],
  channel: Nullable<IChannel>,
  status: ChannelsStatus
}

export const initialState: State = {
  items: [],
  channel: null,
  status: ChannelsStatus.Initial
}

const slice = createSlice({
  name: 'channels',
  initialState,
  reducers: {
    fetchAll: (state, _action: PayloadAction<IStation['id']>) => ({
      ...state,
      status: ChannelsStatus.Fetching,
    }),
    received: (state, action: PayloadAction<IChannel[]>) => ({
      ...state,
      items: action.payload,
      status: ChannelsStatus.Received
    }),
    changeChannel: (state, action: PayloadAction<IChannel['id']>) => ({
      ...state,
      channel: state.items.find(channel => channel.id === action.payload) || null
    }),
    error: state => ({
      ...state,
      status: ChannelsStatus.Error
    })
  },
  extraReducers: builder => {
    builder
      .addCase(changeStation, state => ({
        ...state,
        channel: null
      }))
  }
})

export const {
  fetchAll,
  received,
  changeChannel,
  error
} = slice.actions

export const selectItems: Selector<IChannel[]> = state =>
  state.channels.items

export const selectCurrentChannel: Selector<Nullable<IChannel>> = state =>
  state.channels.channel

export const selectIsFetching: Selector<boolean> = state =>
  state.channels.status === ChannelsStatus.Fetching

export default slice
