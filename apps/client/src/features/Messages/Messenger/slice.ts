import { createSlice, type PayloadAction } from '@reduxjs/toolkit'
import { type Channel } from 'models/channel'
import { type Selector } from 'app/store'

export enum MessengerStatus {
  Initial = 'Initial',
  Posting = 'Posting',
  Error = 'Error'
}

export type PostPayload = {
  channelId: Channel['id']
  content: string
}

export type State = {
  status: MessengerStatus
}

export const initialState: State = {
  status: MessengerStatus.Initial
}

const slice = createSlice({
  name: 'messenger',
  initialState,
  reducers: {
    post: (state, _action: PayloadAction<PostPayload>) => ({
      ...state,
      status: MessengerStatus.Posting
    }),
    posted: state => ({
      ...state,
      status: MessengerStatus.Initial
    }),
    error: state => ({
      ...state,
      status: MessengerStatus.Error
    })
  }
})

export const {
  post,
  posted,
  error
} = slice.actions

export const selectIsPosting: Selector<boolean> = state =>
  state.messenger.status === MessengerStatus.Posting

export default slice
