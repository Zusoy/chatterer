import React, { useEffect } from 'react'
import { type Station } from 'models/station'
import { type Channel } from 'models/channel'
import {
  fetchAll,
  changeChannel,
  selectItems,
  selectCurrentChannel,
  selectIsFetching
} from 'features/Channels/slice'
import { useDispatch, useSelector } from 'react-redux'
import { Card, List as MatList, ListItem } from '@material-tailwind/react'
import Fallback from 'features/Channels/List/Fallback'
import StationControls, { type Props as ControlsProps } from 'features/Stations/StationControl'

type Props = ControlsProps & {
  stationId: Station['id']
}

const List: React.FC<Props> = ({ stationId, stationName, onNewChannel }) => {
  const dispatch = useDispatch()
  const items = useSelector(selectItems)
  const current = useSelector(selectCurrentChannel)
  const isFetching = useSelector(selectIsFetching)

  const changeChannelHandler = (id: Channel['id']): void => {
    dispatch(changeChannel(id))
  }

  useEffect(() => {
    dispatch(fetchAll(stationId))
  }, [dispatch, stationId])

  return (
    <Card className='flex flex-col w-72 h-[calc(100vh-78px)] rounded-none bg-white' placeholder={undefined}>
      <StationControls stationName={stationName} onNewChannel={onNewChannel} />
      <MatList placeholder={undefined}>
        {isFetching
          ? <Fallback prediction={6} />
          : items.map(
            channel =>
              <ListItem
                key={channel.id}
                selected={current === channel.id}
                placeholder={undefined}
                onClick={() => changeChannelHandler(channel.id)}
              >
                {channel.name}
              </ListItem>
          )
        }
      </MatList>
    </Card>
  )
}

export default List
