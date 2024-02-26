import React, { useEffect } from 'react'
import { type Station } from 'models/station'
import { type Channel } from 'models/channel'
import {
  fetchAll,
  changeChannel,
  selectItems,
  selectCurrentChannel,
  selectIsFetching
} from 'features/Channels/List/slice'
import { useDispatch, useSelector } from 'react-redux'
import { Card, List as MatList, ListItem } from '@material-tailwind/react'
import Fallback from 'features/Channels/List/Fallback'

type Props = {
  stationId: Station['id']
}

const List: React.FC<Props> = ({ stationId }) => {
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
    <Card className='w-72 h-[calc(100vh-78px)] rounded-none' placeholder={undefined}>
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
