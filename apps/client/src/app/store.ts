import { configureStore, combineReducers } from '@reduxjs/toolkit';
import effects from 'app/effects';
import createSagaMiddleware from '@redux-saga/core';
import me from 'features/Me/slice';
import authentication from 'features/Me/Authentication/slice';
import registration from 'features/Me/Registration/slice';
import stations from 'features/StationsSidebar/slice';

export const reducer = combineReducers({
  me: me.reducer,
  authentication: authentication.reducer,
  registration: registration.reducer,
  stations: stations.reducer,
})

const sagaMiddleware = createSagaMiddleware()

export const store = configureStore({
  reducer,
  middleware: (getDefaultMiddleware) => getDefaultMiddleware().concat(sagaMiddleware),
  devTools: process.env.NODE_ENV !== 'production',
})

sagaMiddleware.run(effects);

export type RootState = ReturnType<typeof store.getState>
export type Selector<S> = (state: RootState) => S
