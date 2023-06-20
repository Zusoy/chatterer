import slice, {
  post,
  posted,
  error,
  initialState,
  MessageStatus,
  State,
} from 'features/Messages/Create/slice'

describe('Features/Messages/Create', () => {
  it('reduces post action', () => {
    expect(slice.reducer(initialState, post({ channelId: 'id', content: 'Hello' }))).toEqual({
      ...initialState,
      status: MessageStatus.Posting,
    })
  })

  it('reduces posted action', () => {
    const initial: State = {
      ...initialState,
      status: MessageStatus.Posting,
    }

    expect(slice.reducer(initial, posted())).toEqual(initialState)
  })

  it('handles error', () => {
    expect(slice.reducer(initialState, error())).toEqual({
      ...initialState,
      status: MessageStatus.Error,
    })
  })
})
