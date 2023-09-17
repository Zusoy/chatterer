import { PayloadAction, createSlice } from '@reduxjs/toolkit'
import { IMessage } from 'models/message'
import { Selector } from 'app/store'
import { IChannel } from 'models/channel'
import { changeChannel } from 'features/Channels/List/slice'

export enum MessagesStatus {
  Initial = 'Initial',
  Fetching = 'Fetching',
  Received = 'Received',
  Error = 'Error'
}

export interface State {
  items: IMessage[]
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
    fetchAll: (state, _action: PayloadAction<IChannel['id']>) => ({
      ...state,
      status: MessagesStatus.Fetching
    }),
    fetchAllAndSubscribe: (state, _action: PayloadAction<IChannel['id']>) => ({
      ...state,
      status: MessagesStatus.Fetching
    }),
    unsubscribe: state => state,
    received: (state, action: PayloadAction<IMessage[]>) => ({
      ...state,
      items: action.payload,
      status: MessagesStatus.Received,
    }),
    upsertMany: (state, action: PayloadAction<IMessage[]>) => ({
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

export const selectItems: Selector<IMessage[]> = state =>
  state.messages.items

export default slice
