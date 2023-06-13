import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { fetchListAndSubscribe, unsubscribeList, selectItems } from 'features/Messages/slice'
import { Channel } from 'models/channel'
import Message from 'widgets/Message/Message'
import styled from 'styled-components'

interface Props {
  readonly channel: Channel
}

const Messages: React.FC<Props> = ({ channel }) => {
  const dispatch = useDispatch()
  const items = useSelector(selectItems)

  useEffect(() => {
    dispatch(fetchListAndSubscribe(channel.id))

    return () => {
      dispatch(unsubscribeList())
    }
  }, [ dispatch, channel ])

  return (
    <Wrapper>
      { items.map(
        message =>
          <Message
            key={ message.id }
            authorName={ message.author.name }
            content={ message.content }
            date={ message.createdAt }
          />
      ) }
    </Wrapper>
  )
}

const Wrapper = styled.div(({ theme }) => `
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  flex-direction: column;
  display: flex;
  gap: ${ theme.gap.m };
  overflow-y: scroll;
  overflow-x: hidden;
  overflow-anchor: none;
  align-items: stretch;
  height: calc(100% - 40px - 40px);
`)

export default Messages
