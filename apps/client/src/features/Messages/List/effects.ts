import { PayloadAction } from '@reduxjs/toolkit'
import { call, put, fork, takeLatest, take, cancel, cancelled } from 'redux-saga/effects'
import { received, error, fetchListAndSubscribe, unsubscribeList, upsertMany } from 'features/Messages/List/slice'
import { getAndStream } from 'services/api'
import { Message } from 'models/message'
import { Nullable } from 'utils'
import { Task } from 'redux-saga'
import { Push, createSynchronizationChannel } from 'services/synchronization'

export function* listSubscriber(action: PayloadAction<string>): Generator {
  const id = action.payload

  try {
    const info = (yield call(getAndStream, `/channel/${id}/messages`)) as [ Promise<Message[]>, Nullable<EventSource> ]
    const items = (yield info[0]) as Message[]
    const eventSource = info[1]

    yield put(received(items))

    if (!!eventSource) {
      const eventSourceChannel: any = yield call(createSynchronizationChannel<Message>, eventSource)

      while (true) {
        try {
          const push = (yield take(eventSourceChannel)) as Push<Message>
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
    yield put(error)
  }
}

function* eventSourceHandler(action: PayloadAction<string>): Generator {
  const subscription = (yield fork(listSubscriber, action)) as Task
  yield take(unsubscribeList)
  yield cancel(subscription)
}

export default function* rootSaga(): Generator {
  yield takeLatest(fetchListAndSubscribe, eventSourceHandler)
}
