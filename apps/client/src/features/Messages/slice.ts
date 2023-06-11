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
    received: (state, action: PayloadAction<Message[]>) => ({
      ...state,
      items: action.payload,
      status: MessagesStatus.Received,
    }),
    error: state => ({
      ...state,
      status: MessagesStatus.Error,
    }),
  },
})

export const {
  fetchAll,
  received,
  error,
} = slice.actions

export const selectItems: Selector<Message[]> = state =>
  state.messages.items

export default slice
