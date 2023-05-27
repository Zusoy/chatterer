import { configureStore } from '@reduxjs/toolkit'
import createSagaMiddleware from '@redux-saga/core'
import effects from 'app/effects'
import reducer from 'app/reducers'

const sagaMiddleware = createSagaMiddleware()

export const store = configureStore({
  reducer,
  middleware: (getDefaultMiddleware) => getDefaultMiddleware().concat(sagaMiddleware),
})

sagaMiddleware.run(effects)

export type RootState = ReturnType<typeof store.getState>
export type AppDispatch = typeof store.dispatch
