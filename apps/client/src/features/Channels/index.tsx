import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { fetchAll, selectItems, selectIsFetching } from 'features/Channels/slice'
import LineWave from 'widgets/Loading/LineWave'
import Badge from 'widgets/Channel/Badge'
import styled from 'styled-components'
import { theme } from 'app/theme'

interface Props {
  readonly stationId: string
}

const Channels: React.FC<Props> = ({ stationId }) => {
  const dispatch = useDispatch()
  const items = useSelector(selectItems)
  const isFetching = useSelector(selectIsFetching)

  useEffect(() => {
    dispatch(fetchAll(stationId))
  }, [ dispatch, stationId ])

  return (
    <Wrapper>
      {
        isFetching
          ? <LineWave width={ 50 } height={ 50 } color={ theme.colors.white } />
          : items.map(
            channel => <Badge key={ channel.id } name={ channel.name } onClick={ () => {} } />
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

export default Channels
