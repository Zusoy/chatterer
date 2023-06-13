import slice, {
  initialState,
  fetchAll,
  received,
  error,
  changeChannel,
  ChannelsStatus,
  State
} from 'features/Channels/slice'
import { channelMock, messageMock } from 'test-utils'

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

  describe('changeChannel', () => {
    it('ignores not found channel', () => {
      expect(slice.reducer(initialState, changeChannel('id'))).toEqual(initialState)
    })

    it('updates current channel', () => {
      const initial: State = {
        ...initialState,
        items: [ channelMock ]
      }

      expect(slice.reducer(initial, changeChannel(channelMock.id))).toEqual({
        ...initial,
        channel: channelMock
      })
    })
  })
})
