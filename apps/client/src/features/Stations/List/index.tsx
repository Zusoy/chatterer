import React, { useEffect, useState } from 'react'
import { theme } from 'app/theme'
import { useDispatch, useSelector } from 'react-redux'
import { fetchAll, selectStations, selectIsFetching, changeStation, selectCurrentStation } from 'features/Stations/List/slice'
import Badge from 'widgets/Station/Badge'
import Puff from 'widgets/Loading/Puff'
import styled from 'styled-components'
import JoinBadge from 'widgets/Station/JoinBadge'
import Join from 'features/Stations/Join'

const List: React.FC = () => {
  const dispatch = useDispatch()
  const isFetching = useSelector(selectIsFetching)
  const items = useSelector(selectStations)
  const current = useSelector(selectCurrentStation)
  const [ isJoinModalVisible, setJoinModalVisibility ] = useState<boolean>(false)

  const changeStationHandler = (id: string): void => {
    dispatch(changeStation(id))
  }

  useEffect(() => {
    dispatch(fetchAll())
  }, [ dispatch ])

  return (
    <Wrapper>
      { isJoinModalVisible &&
        <Join onCancel={ () => setJoinModalVisibility(false) } />
      }
      { isFetching
        ? <Puff
            width={ 50 }
            height={ 50 }
            color={ theme.colors.white }
            radius={ 10 }
          />
        : <React.Fragment>
            { items.map(
            station =>
              <Badge
                key={ station.id }
                active={ !!current && current.id === station.id }
                name={ station.name }
                onClick={ () => changeStationHandler(station.id) }
              />
            ) }
            <JoinBadge onClick={ () => setJoinModalVisibility(!isJoinModalVisible) } />
          </React.Fragment>
      }
    </Wrapper>
  )
}

const Wrapper = styled.div(({ theme }) => `
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: ${ theme.gap.sm };
  margin-top: ${ theme.gap.m };
`)

export default List
