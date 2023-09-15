import slice, {
  post,
  posted,
  error,
  initialState,
  MessengerStatus,
  State,
} from 'features/Messages/Messenger/slice'

describe('Features/Messages/Messenger', () => {
  it('reduces post action', () => {
    expect(slice.reducer(initialState, post({ channelId: 'id', content: 'Hello' }))).toEqual({
      ...initialState,
      status: MessengerStatus.Posting,
    })
  })

  it('reduces posted action', () => {
    const initial: State = {
      ...initialState,
      status: MessengerStatus.Posting,
    }

    expect(slice.reducer(initial, posted())).toEqual(initialState)
  })

  it('handles error', () => {
    expect(slice.reducer(initialState, error())).toEqual({
      ...initialState,
      status: MessengerStatus.Error,
    })
  })
})
