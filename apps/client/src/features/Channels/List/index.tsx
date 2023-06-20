import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { fetchAll, selectItems, selectIsFetching, changeChannel, selectCurrentChannel } from 'features/Channels/List/slice'
import LineWave from 'widgets/Loading/LineWave'
import Badge from 'widgets/Channel/Badge'
import styled from 'styled-components'
import { theme } from 'app/theme'

interface Props {
  readonly stationId: string
}

const List: React.FC<Props> = ({ stationId }) => {
  const dispatch = useDispatch()
  const items = useSelector(selectItems)
  const current = useSelector(selectCurrentChannel)
  const isFetching = useSelector(selectIsFetching)

  const changeChannelHandler = (id: string): void => {
    dispatch(changeChannel(id))
  }

  useEffect(() => {
    dispatch(fetchAll(stationId))
  }, [ dispatch, stationId ])

  return (
    <Wrapper>
      {
        isFetching
          ? <LineWave width={ 50 } height={ 50 } color={ theme.colors.white } />
          : items.map(
            channel =>
              <Badge
                key={ channel.id }
                active={ !!current && current.id === channel.id }
                name={ channel.name }
                onClick={ () => changeChannelHandler(channel.id) }
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
  margin-top: ${ theme.gap.l };
`)

export default List
