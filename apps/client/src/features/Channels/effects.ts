import { call, put, take, takeLatest } from 'redux-saga/effects'
import { fetchAll, received, error } from 'features/Channels/slice'
import { getAndStream } from 'services/api'
import { PayloadAction } from '@reduxjs/toolkit'
import { Channel } from 'models/channel'
import { Nullable } from 'utils'
import { Push, createSynchronizationChannel } from 'services/synchronization'

export function* fetchAllAndSubscribeEffect(action: PayloadAction<string>): Generator {
  const id = action.payload

  try {
    const info = (yield call(getAndStream, `/station/${id}/channels`)) as [ Promise<Channel[]>, Nullable<EventSource> ]
    const items = (yield info[0]) as Channel[]
    const eventSource = info[1]

    yield put(received(items))

    if (!!eventSource) {
      try {
        while (true) {
          const push = (yield take(createSynchronizationChannel(eventSource))) as Push
          console.log(push)
        }
      } finally {
        console.log('event source closed')
      }
    }
  } catch (e) {
    console.error(e)
    yield put(error())
  }
}

export default function* rootSaga(): Generator {
  yield takeLatest(fetchAll, fetchAllAndSubscribeEffect)
}
