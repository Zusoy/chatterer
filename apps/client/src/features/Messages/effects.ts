import { PayloadAction } from '@reduxjs/toolkit'
import { call, put, take, cancelled, takeLatest } from 'redux-saga/effects'
import { fetchAll, received, error } from 'features/Messages/slice'
import { getAndStream } from 'services/api'
import { Message } from 'models/message'
import { Nullable } from 'utils'
import { createSynchronizationChannel, Push } from 'services/synchronization'

export function* fetchAllAndSubscribeEffect(action: PayloadAction<string>): Generator {
  const id = action.payload

  try {
    const info = (yield call(getAndStream, `/channel/${id}/messages`)) as [ Promise<Message[]>, Nullable<EventSource> ]
    const items = (yield info[0]) as Message[]
    const eventSource = info[1]

    yield put(received(items))

    if (eventSource) {
      yield eventSourceHandler(eventSource)
    }
  } catch (e) {
    console.error(e)
    yield put(error)
  }
}

export function* eventSourceHandler(eventSource: EventSource): Generator {
  const eventSourceChannel: any = yield call(createSynchronizationChannel<Message>, eventSource)

  while (true) {
    try {
      const push = (yield take(eventSourceChannel)) as Push<Message>
      console.log(push)
    } catch (e) {
      console.error(e)
    } finally {
      if (yield cancelled()) {
        eventSource.close()
      }
    }
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(fetchAll, fetchAllAndSubscribeEffect)
}
