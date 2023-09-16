import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { fetchAll, changeChannel, selectItems, selectCurrentChannel, selectIsFetching } from 'features/Channels/List/slice'
import { IStation } from 'models/station'
import { IChannel } from 'models/channel'
import Container from '@mui/material/Container'
import LinearProgress from '@mui/material/LinearProgress'
import MuiList from '@mui/material/List'
import Channel from 'widgets/Channel/Item'

interface Props {
  readonly stationId: IStation['id']
}

const List: React.FC<Props> = ({ stationId }) => {
  const dispatch = useDispatch()
  const items = useSelector(selectItems)
  const current = useSelector(selectCurrentChannel)
  const isFetching = useSelector(selectIsFetching)

  const changeChannelHandler = (id: IChannel['id']): void => {
    dispatch(changeChannel(id))
  }

  useEffect(() => {
    dispatch(fetchAll(stationId))
  }, [ dispatch, stationId ])

  if (isFetching) {
    return (
      <Container maxWidth='md' sx={{ mt: 5 }}>
        <LinearProgress color='inherit' />
      </Container>
    )
  }

  return (
    <MuiList component='nav'>
      { items.map(
        channel =>
          <Channel
            key={ channel.id }
            name={ channel.name }
            selected={ current?.id === channel.id }
            onClick={() => changeChannelHandler(channel.id) }
          />
      )}
    </MuiList>
  )
}

export default List
