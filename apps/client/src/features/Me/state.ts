import { AnyAction, createSlice } from '@reduxjs/toolkit';
import { User } from 'models/user';
import { ActionTypes, AuthenticatedAction } from 'features/Me/Authentication/actions';

export interface State {
  id: User['id'] | null;
}

export const initialState: State = ({
  id: null,
})

function isAuthenticatedAction(action: AnyAction): action is AuthenticatedAction {
  return action.type === ActionTypes.Authenticated;
}

const slice = createSlice({
  name: 'me',
  initialState,
  reducers: {},
  extraReducers: builder => {
    builder.addMatcher(isAuthenticatedAction, (state, { id }) => ({
      ...state,
      id,
    }))
  }
})

export default slice;
