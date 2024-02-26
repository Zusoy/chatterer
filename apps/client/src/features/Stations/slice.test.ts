import { describe, test, expect } from 'vitest'
import slice, {
  type State,
  fetchAll,
  received,
  error,
  changeStation,
  initialState,
  StationsStatus
} from 'features/Stations/slice'
import { stationMock } from 'test-utils'

describe('Features/Stations/List', () => {
  test ('it reduces fetchAll action', () => {
    expect(slice.reducer(initialState, fetchAll())).toEqual({
      ...initialState,
      status: StationsStatus.Fetching
    })
  })

  test('it reduces received action', () => {
    expect(slice.reducer(initialState, received([stationMock]))).toEqual({
      ...initialState,
      status: StationsStatus.Received,
      items: [stationMock],
      station: stationMock.id
    })
  })

  test('it reduces error action', () => {
    expect(slice.reducer(initialState, error())).toEqual({
      ...initialState,
      status: StationsStatus.Error,
    })
  })

  describe('changeStation', () => {
    test('it ignores not found station', () => {
      expect(slice.reducer(initialState, changeStation('c3e014f3-dc32-4b2b-afd9-ab597da74046'))).toEqual(
        initialState
      )
    })

    test('it updates current station', () => {
      const initial: State = {
        ...initialState,
        items: [stationMock]
      }

      expect(slice.reducer(initial, changeStation(stationMock.id))).toEqual({
        ...initial,
        station: stationMock.id,
      })
    })
  })
})
