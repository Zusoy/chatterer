import slice, {
  initialState,
  fetchAll,
  received,
  error,
  ChannelsStatus
} from 'features/Channels/slice'
import { channelMock } from 'test-utils'

describe('Features/Channels', () => {
  it('reduces fetchAll action', () => {
    expect(slice.reducer(initialState, fetchAll)).toEqual({
      ...initialState,
      status: ChannelsStatus.Fetching,
    })
  })

  it('reduces received action', () => {
    expect(slice.reducer(initialState, received([ channelMock ]))).toEqual({
      ...initialState,
      status: ChannelsStatus.Received,
      items: [ channelMock ]
    })
  })

  it('reduces error action', () => {
    expect(slice.reducer(initialState, error())).toEqual({
      ...initialState,
      status: ChannelsStatus.Error,
    })
  })
})
