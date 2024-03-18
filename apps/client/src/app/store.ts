import { configureStore } from '@reduxjs/toolkit'
import createSagaMiddleware from 'redux-saga'
import reducer from 'app/reducers'
import effects from 'app/effects'

const sagaMiddleware = createSagaMiddleware()

export const store = configureStore({
  reducer,
  middleware: getDefaultMiddleware => getDefaultMiddleware().concat(sagaMiddleware)
})

sagaMiddleware.run(effects)

export type RootState = ReturnType<typeof store.getState>
export type Selector<S> = (state: RootState) => S
export type AppDispatch = typeof store.dispatch
