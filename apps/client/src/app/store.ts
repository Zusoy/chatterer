import { configureStore, combineReducers, AnyAction, applyMiddleware } from '@reduxjs/toolkit';
import authentication from 'features/Me/Authentication/state';
import me from 'features/Me/state';

export const reducer = combineReducers({
  me: me.reducer,
  authentication,
});

export const store = configureStore({
  reducer,
  devTools: process.env.NODE_ENV !== 'production',
});

export type RootState = ReturnType<typeof store.getState>;
