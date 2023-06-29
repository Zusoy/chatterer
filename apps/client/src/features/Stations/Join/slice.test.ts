import slice, { join, joined, error, initialState, JoinStatus } from 'features/Stations/Join/slice'

describe('Features/Stations/Join', () => {
  it('reduces join action', () => {
    expect(slice.reducer(initialState, join({ token: 'token' }))).toEqual({
      ...initialState,
      status: JoinStatus.Joining,
    })
  })

  it('reduces joined action', () => {
    const initial = slice.reducer(initialState, join({ token: 'token' }))

    expect(slice.reducer(initial, joined())).toEqual(initialState)
  })

  it('reduces error action', () => {
    expect(slice.reducer(initialState, error())).toEqual({
      ...initialState,
      status: JoinStatus.Error
    })
  })
})
