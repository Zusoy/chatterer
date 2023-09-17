import { call, put, fork, takeLatest, take, cancel, cancelled } from 'redux-saga/effects'
import { received, error, fetchAllAndSubscribe, unsubscribe, upsertMany } from 'features/Messages/List/slice'
import { getAndStream } from 'services/api'
import { IMessage } from 'models/message'
import { Nullable } from 'utils'
import { Task } from 'redux-saga'
import { Push, createSynchronizationChannel } from 'services/synchronization'
import { PayloadAction } from '@reduxjs/toolkit'
import { IChannel } from 'models/channel'

export function* listSubscriber(action: PayloadAction<IChannel['id']>): Generator {
  const id = action.payload

  try {
    const info = (yield call(getAndStream, `/channel/${id}/messages`)) as [ Promise<IMessage[]>, Nullable<EventSource> ]
    const items = (yield info[0]) as IMessage[]
    const eventSource = info[1]

    yield put(received(items))

    if (!!eventSource) {
      const eventSourceChannel: any = yield call(createSynchronizationChannel<IMessage>, eventSource)

      while (true) {
        try {
          const push = (yield take(eventSourceChannel)) as Push<IMessage>
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

function* eventSourceHandler(action: PayloadAction<string>): Generator {
  const subscription = (yield fork(listSubscriber, action)) as Task
  yield take(unsubscribe)
  yield cancel(subscription)
}

export default function* rootSaga(): Generator {
  yield takeLatest(fetchAllAndSubscribe, eventSourceHandler)
}
