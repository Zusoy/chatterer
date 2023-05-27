import { createSlice } from '@reduxjs/toolkit'
import { User } from 'models/user'

interface State {
  id: User['id'] | null
}

const initialState: State = {
  id: null
}

const slice = createSlice({
  name: 'me',
  initialState,
  reducers: {
  }
})

export default slice
