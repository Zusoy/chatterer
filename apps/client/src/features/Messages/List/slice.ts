import { createSlice, PayloadAction } from '@reduxjs/toolkit'
import { Message } from 'models/message'
import { Selector } from 'app/store'

export enum MessagesStatus {
  Fetching = 'Fetching',
  Received = 'Received',
  Error = 'Error'
}

export interface State {
  items: Message[]
  status: MessagesStatus
}

export const initialState: State = {
  items: [],
  status: MessagesStatus.Fetching,
}

const slice = createSlice({
  name: 'messages',
  initialState,
  reducers: {
    fetchAll: (state, _action: PayloadAction<string>) => ({
      ...state,
      status: MessagesStatus.Fetching,
    }),
    fetchListAndSubscribe: (state, _action: PayloadAction<string>) => ({
      ...state,
      status: MessagesStatus.Fetching,
    }),
    unsubscribeList: state => state,
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
})

export const {
  fetchAll,
  fetchListAndSubscribe,
  unsubscribeList,
  received,
  upsertMany,
  error,
} = slice.actions

export const selectItems: Selector<Message[]> = state =>
  state.messages.items

export default slice
