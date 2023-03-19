import { createSlice } from '@reduxjs/toolkit';
import { User } from 'models/User';
import { Selector } from 'app/store';
import authentication from 'features/Me/Authentication/slice';

interface State {
  item: User | null;
}

export const initialState: State = ({
  item: null,
});

const slice = createSlice({
  name: 'me',
  initialState,
  reducers: {},
  extraReducers: builder => {
    builder
      .addCase(authentication.actions.authenticated, (state, { payload: item }) => ({
        ...state,
        item,
      }))
  }
});

export const selectIsAuth: Selector<boolean> = state => state.me.item !== null;
export const selectAuthenticatedUser: Selector<User|null> = state => state.me.item;

export default slice;
