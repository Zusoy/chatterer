import { describe, expect, test } from 'vitest'
import slice, {
  initialState,
  fetchAll,
  received,
  error,
  changeChannel,
  ChannelsStatus,
  type State
} from 'features/Channels/List/slice'
import { channelMock } from 'test-utils'

describe('Features/Channels/List', () => {
  test('it reduces fetchAll action', () => {
    expect(slice.reducer(initialState, fetchAll('stationId'))).toEqual({
      ...initialState,
      status: ChannelsStatus.Fetching
    })
  })

  test('it reduces received action', () => {
    expect(slice.reducer(initialState, received([ channelMock ]))).toEqual({
      ...initialState,
      status: ChannelsStatus.Received,
      items: [ channelMock ],
      channel: channelMock.id
    })
  })

  test('it reduces error action', () => {
    expect(slice.reducer(initialState, error())).toEqual({
      ...initialState,
      status: ChannelsStatus.Error,
    })
  })

  describe('changeChannel', () => {
    test('it ignores not found channel', () => {
      expect(slice.reducer(initialState, changeChannel('id'))).toEqual(initialState)
    })

    test('it updates current channel', () => {
      const initial: State = {
        ...initialState,
        items: [ channelMock ]
      }

      expect(slice.reducer(initial, changeChannel(channelMock.id))).toEqual({
        ...initial,
        channel: channelMock.id
      })
    })
  })
})
