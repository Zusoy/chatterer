import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { fetchAll, changeChannel, selectItems, selectCurrentChannel, selectIsFetching } from 'features/Channels/List/slice'
import { IStation } from 'models/station'
import { IChannel } from 'models/channel'
import Container from '@mui/material/Container'
import LinearProgress from '@mui/material/LinearProgress'
import MuiList from '@mui/material/List'
import ListItemButton from '@mui/material/ListItemButton'
import ListItemIcon from '@mui/material/ListItemIcon'
import ListItemText from '@mui/material/ListItemText'
import Tag from '@mui/icons-material/Tag'

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
          <ListItemButton
            key={ channel.id }
            onClick={ () => changeChannelHandler(channel.id) }
            selected={ current?.id === channel.id }
          >
            <ListItemIcon>
              <Tag />
            </ListItemIcon>
            <ListItemText primary={ channel.name } />
          </ListItemButton>
      )}
    </MuiList>
  )
}

export default List
