import { type Task } from 'redux-saga'
import { type Message } from 'models/message'
import { type Channel } from 'models/channel'
import { type PayloadAction } from '@reduxjs/toolkit'
import { call, put, takeLatest, take as waitFor, cancelled, fork, cancel } from 'redux-saga/effects'
import { received, error, upsertMany, unsubscribe, fetchAllAndSubscribe } from 'features/Messages/List/slice'
import { get, getAndStream, type StreamResponse } from 'services/api'
import { createSynchronizationChannel, type Push } from 'services/synchronization'

export function* listSubscriber(action: PayloadAction<Channel['id']>): Generator {
  const id = action.payload

  try {
    const info = (yield call(getAndStream, `/channel/${id}/messages`)) as StreamResponse<Message>
    const items = (yield info[0]) as Message[]
    const eventSource = info[1]

    yield put(received(items))

    if (!!eventSource) {
      const eventSourceChannel: any = yield call(createSynchronizationChannel<Message>, eventSource)

      while (true) {
        try {
          const push = (yield waitFor(eventSourceChannel)) as Push<Message>
          const payload = push.payload

          yield put(upsertMany(payload ? [ payload ] : []))
        } catch (e) {
          eventSourceChannel.close()
        } finally {
          if (yield cancelled()) {
            eventSourceChannel.close()
          }
        }
      }
    }
  } catch (e) {
    yield put(error())
  }
}

export function* eventSourceHandler(action: PayloadAction<string>): Generator {
  const subscription = (yield fork(listSubscriber, action)) as Task

  yield waitFor(unsubscribe)
  yield cancel(subscription)
}

export function* fetchAllNonStreamEffect(action: PayloadAction<Channel['id']>): Generator {
  const id = action.payload

  try {
    const items = (yield call(get, `/channel/${id}/messages`)) as Message[]
    yield put(received(items))
  } catch (e) {
    yield put(error())
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(fetchAllAndSubscribe, eventSourceHandler)
}
