import React, { useEffect } from 'react'
import { theme } from 'app/theme'
import { useDispatch, useSelector } from 'react-redux'
import { fetchAll, selectStations, selectIsFetching, changeStation, selectCurrentStation } from 'features/Stations/List/slice'
import Badge from 'widgets/Station/Badge'
import Puff from 'widgets/Loading/Puff'
import styled from 'styled-components'

const List: React.FC = () => {
  const dispatch = useDispatch()
  const isFetching = useSelector(selectIsFetching)
  const items = useSelector(selectStations)
  const current = useSelector(selectCurrentStation)

  const changeStationHandler = (id: string): void => {
    dispatch(changeStation(id))
  }

  useEffect(() => {
    dispatch(fetchAll())
  }, [ dispatch ])

  return (
    <Wrapper>
      { isFetching
        ? <Puff
            width={ 50 }
            height={ 50 }
            color={ theme.colors.white }
            radius={ 10 }
          />
        : items.map(
            station =>
              <Badge
                key={ station.id }
                active={ !!current && current.id === station.id }
                name={ station.name }
                onClick={ () => changeStationHandler(station.id) }
              />
          )
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
