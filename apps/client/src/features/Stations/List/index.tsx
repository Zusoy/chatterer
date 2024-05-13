import React, { useEffect } from 'react'
import { type Station } from 'models/station'
import { useDispatch, useSelector } from 'react-redux'
import {
  fetchAll,
  selectIsFetching,
  selectStations,
  changeStation,
  selectCurrentStationId
} from 'features/Stations/slice'
import StationBadge from 'widgets/Station/StationBadge'
import Fallback from 'features/Stations/List/Fallback'
import AddStation from 'widgets/Station/NewStationBadge'

type Props = {
  onNewClick: React.MouseEventHandler<HTMLElement>
}

const List: React.FC<Props> = ({ onNewClick }) => {
  const dispatch = useDispatch()
  const isFetching = useSelector(selectIsFetching)
  const items = useSelector(selectStations)
  const current = useSelector(selectCurrentStationId)

  const changeStationHandler = (id: Station['id']): void => {
    if (current === id) {
      return
    }

    dispatch(changeStation(id))
  }

  useEffect(() => {
    dispatch(fetchAll())
  }, [dispatch])

  return (
    <div className="space-y-2 font-medium">
      <div className='flex flex-col'>
        {isFetching
          ? <Fallback prediction={4} />
          :
          <React.Fragment>
            {items.map(
              station =>
                <StationBadge
                  key={station.id}
                  active={current === station.id}
                  name={station.name}
                  onClick={() => changeStationHandler(station.id)}
                />
            )}
            <AddStation onClick={onNewClick} />
          </React.Fragment>
        }
      </div>
    </div>
  )
}

export default List
