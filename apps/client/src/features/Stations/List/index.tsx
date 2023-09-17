import React, { useEffect, useState } from 'react'
import MuiList from '@mui/material/List'
import LinearProgress from '@mui/material/LinearProgress'
import Station from 'widgets/Station/Item'
import AddStation from 'widgets/Station/AddStation'
import Container from '@mui/material/Container'
import Join from 'features/Stations/Join'
import { useDispatch, useSelector } from 'react-redux'
import { selectCurrentStation, selectIsFetching, selectStations, fetchAll, changeStation } from 'features/Stations/List/slice'
import { IStation } from 'models/station'

const List: React.FC = () => {
  const dispatch = useDispatch()
  const isFetching = useSelector(selectIsFetching)
  const items = useSelector(selectStations)
  const current = useSelector(selectCurrentStation)
  const [ isJoinModalVisible, setJoinModalVisibility ] = useState<boolean>(false)

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
      { isJoinModalVisible &&
        <Join onCancel={ () => setJoinModalVisibility(false) } />
      }
      { items.map(
        station =>
          <Station
            key={ station.id }
            name={ station.name }
            selected={ current?.id === station.id }
            onClick={() => changeStationHandler(station.id) }
          />
      ) }
      <AddStation onClick={ () => setJoinModalVisibility(true) } />
    </MuiList>
  )
}

export default List
