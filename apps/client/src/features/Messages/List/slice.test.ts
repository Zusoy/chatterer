import slice, {
  fetchAll,
  received,
  error,
  initialState,
  MessagesStatus
} from 'features/Messages/List/slice'
import { messageMock } from 'test-utils'

describe('Features/Messages/List', () => {
  it('reduces fetchAll action', () => {
    expect(slice.reducer(initialState, fetchAll('stationId'))).toEqual({
      ...initialState,
      status: MessagesStatus.Fetching,
    })
  })

  it('reduces received action', () => {
    expect(slice.reducer(initialState, received([ messageMock ]))).toEqual({
      ...initialState,
      status: MessagesStatus.Received,
      items: [ messageMock ],
    })
  })

  it('reduces error action', () => {
    expect(slice.reducer(initialState, error())).toEqual({
      ...initialState,
      status: MessagesStatus.Error,
    })
  })
})
