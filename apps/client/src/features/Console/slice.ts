import { createSlice } from '@reduxjs/toolkit'
import { type AppDispatch, type RootState } from 'app/store'
import React from 'react'
import { type Nullable } from 'utils'

export type Command = {
  label: string
  tag: string
  description: Nullable<string>
  icon: Nullable<React.ReactNode>
  process: (dispatch: AppDispatch, state: RootState) => void
}

export type State = {
  registeredCommands: Command[]
}

export const initialState: State = {
  registeredCommands: []
}

const slice = createSlice({
  name: 'console',
  initialState,
  reducers: {
  }
})

export default slice
