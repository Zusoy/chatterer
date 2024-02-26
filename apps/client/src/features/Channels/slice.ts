import { createSlice, type PayloadAction } from '@reduxjs/toolkit'
import { changeStation } from 'features/Stations/slice'
import { type Nullable } from 'utils'
import { type Selector } from 'app/store'
import { type Station } from 'models/station'
import { type Channel } from 'models/channel'

export enum ChannelsStatus {
  Initial = 'Initial',
  Fetching = 'Fetching',
  Received = 'Received',
  Error = 'Error'
}

export type State = {
  items: Channel[]
  channel: Nullable<Channel['id']>
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
    fetchAll: (state, _action: PayloadAction<Station['id']>) => ({
      ...state,
      status: ChannelsStatus.Fetching,
    }),
    received: (state, action: PayloadAction<Channel[]>) => ({
      ...state,
      items: action.payload,
      status: ChannelsStatus.Received,
      channel: action.payload.length > 0 ? action.payload[0].id : null
    }),
    changeChannel: (state, action: PayloadAction<Channel['id']>) => ({
      ...state,
      channel: state.items.find(channel => channel.id === action.payload)?.id || null
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

export const selectItems: Selector<State['items']> = state =>
  state.channels.items

export const selectCurrentChannel: Selector<State['channel']> = state =>
  state.channels.channel

export const selectIsFetching: Selector<boolean> = state =>
  state.channels.status === ChannelsStatus.Fetching

export default slice
