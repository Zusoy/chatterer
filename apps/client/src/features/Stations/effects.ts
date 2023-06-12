import { fetchAll, received, error } from 'features/Stations/slice'
import { Station } from 'models/station'
import { call, put, take, takeLatest } from 'redux-saga/effects'
import { getAndStream } from 'services/api'
import { createSynchronizationChannel, Push } from 'services/synchronization'
import { Nullable } from 'utils'

export function* fetchAllAndSubscribeEffect(): Generator {
  try {
    const info = (yield call(getAndStream, '/stations')) as [ Promise<Station[]>, Nullable<EventSource> ]
    const items = (yield info[0]) as Station[]
    const eventSource = info[1]

    yield put(received(items))

    if (!!eventSource) {
      try {
        while (true) {
          const push = (yield take(createSynchronizationChannel(eventSource))) as Push
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
