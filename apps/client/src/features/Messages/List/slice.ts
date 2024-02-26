import { createSlice, type PayloadAction } from '@reduxjs/toolkit'
import { changeChannel } from 'features/Channels/slice'
import { type Message } from 'models/message'
import { type Selector } from 'app/store'
import { type Channel } from 'models/channel'

export enum MessagesStatus {
  Initial = 'Initial',
  Fetching = 'Fetching',
  Received = 'Received',
  Error = 'Error'
}

export type State = {
  items: Message[]
  status: MessagesStatus
}

export const initialState: State = {
  items: [],
  status: MessagesStatus.Initial
}

const slice = createSlice({
  name: 'messages',
  initialState,
  reducers: {
    fetchAll: (state, _action: PayloadAction<Channel['id']>) => ({
      ...state,
      status: MessagesStatus.Fetching
    }),
    fetchAllAndSubscribe: (state, _action: PayloadAction<Channel['id']>) => ({
      ...state,
      status: MessagesStatus.Fetching
    }),
    unsubscribe: state => state,
    received: (state, action: PayloadAction<Message[]>) => ({
      ...state,
      items: action.payload,
      status: MessagesStatus.Received,
    }),
    upsertMany: (state, action: PayloadAction<Message[]>) => ({
      ...state,
      items: [
        ...state.items,
        ...action.payload,
      ],
    }),
    error: state => ({
      ...state,
      status: MessagesStatus.Error,
    }),
  },
  extraReducers: builder => {
    builder
      .addCase(changeChannel, state => ({
        ...state,
        items: []
      }))
  }
})

export const {
  fetchAll,
  fetchAllAndSubscribe,
  received,
  upsertMany,
  unsubscribe,
  error
} = slice.actions

export const selectItems: Selector<State['items']> = state =>
  state.messages.items

export const selectIsFetching: Selector<boolean> = state =>
  state.messages.status === MessagesStatus.Fetching

export default slice
