import { createSlice, PayloadAction } from '@reduxjs/toolkit'

export enum MessageStatus {
  Initial = 'Initial',
  Posting = 'Posting',
  Error = 'Error'
}

export interface PostPayload {
  readonly channelId: string
  readonly content: string
}

export interface State {
  status: MessageStatus,
}

export const initialState: State = {
  status: MessageStatus.Initial,
}

const slice = createSlice({
  name: 'message',
  initialState,
  reducers: {
    post: (state, _action: PayloadAction<PostPayload>) => ({
      ...state,
      status: MessageStatus.Posting,
    }),
    posted: state => ({
      ...state,
      status: MessageStatus.Initial,
    }),
    error: state => ({
      ...state,
      status: MessageStatus.Error,
    }),
  }
})

export const {
  post,
  posted,
  error,
} = slice.actions

export default slice