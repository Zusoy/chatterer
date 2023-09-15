import React, { useEffect } from 'react'
import MuiList from '@mui/material/List'
import Avatar from '@mui/material/Avatar'
import ListItemButton from '@mui/material/ListItemButton'
import ListItemAvatar from '@mui/material/ListItemAvatar'
import ListItemText from '@mui/material/ListItemText'
import LinearProgress from '@mui/material/LinearProgress'
import Container from '@mui/material/Container'
import { useDispatch, useSelector } from 'react-redux'
import { selectCurrentStation, selectIsFetching, selectStations, fetchAll, changeStation } from 'features/Stations/List/slice'
import { IStation } from 'models/station'

const List: React.FC = () => {
  const dispatch = useDispatch()
  const isFetching = useSelector(selectIsFetching)
  const items = useSelector(selectStations)
  const current = useSelector(selectCurrentStation)

  const changeStationHandler = (id: IStation['id']): void => {
    dispatch(changeStation(id))
  }

  useEffect(() => {
    dispatch(fetchAll())
  }, [ dispatch ])

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
        station =>
          <ListItemButton
            onClick={ () => changeStationHandler(station.id) } key={ station.id }
            selected={ current?.id === station.id }
          >
            <ListItemAvatar>
              <Avatar alt={ station.name }>{ station.name.substring(0, 1).toUpperCase() }</Avatar>
            </ListItemAvatar>
            <ListItemText primary={ station.name } />
          </ListItemButton>
      ) }
    </MuiList>
  )
}

export default List
