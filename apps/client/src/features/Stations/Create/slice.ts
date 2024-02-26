import { createSlice } from '@reduxjs/toolkit'

export enum CreateStatus {
  Initial = 'Initial',
  Creating = 'Created',
  Error = 'Error'
}

export type State = {
  status: CreateStatus
}

export const initialState: State = {
  status: CreateStatus.Initial
}
