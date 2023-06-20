import slice, {
  State,
  fetchAll,
  received,
  error,
  changeStation,
  initialState,
  StationsStatus
} from 'features/Stations/List/slice'
import { stationMock } from 'test-utils'

describe('Features/Stations', () => {
  it('reduces fetchAll action', () => {
    expect(slice.reducer(initialState, fetchAll())).toEqual({
      ...initialState,
      status: StationsStatus.Fetching
    })
  })

  it('reduces received action', () => {
    expect(slice.reducer(initialState, received([ stationMock ]))).toEqual({
      ...initialState,
      status: StationsStatus.Received,
      items: [ stationMock ]
    })
  })

  it('reduces error action', () => {
    expect(slice.reducer(initialState, error())).toEqual({
      ...initialState,
      status: StationsStatus.Error,
    })
  })

  describe('changeStation', () => {
    it('ignores not found station', () => {
      expect(slice.reducer(initialState, changeStation('c3e014f3-dc32-4b2b-afd9-ab597da74046'))).toEqual(
        initialState
      )
    })

    it('updates current station', () => {
      const initial: State = {
        ...initialState,
        items: [ stationMock ]
      }

      expect(slice.reducer(initial, changeStation(stationMock.id))).toEqual({
        ...initial,
        station: stationMock,
      })
    })
  })
})
