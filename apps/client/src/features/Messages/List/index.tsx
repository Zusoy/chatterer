import React, { useEffect } from 'react'
import { IChannel } from 'models/channel'
import { useDispatch, useSelector } from 'react-redux'
import { fetchAllAndSubscribe, selectItems, unsubscribe } from 'features/Messages/List/slice'
import Box from '@mui/material/Box'
import Message from 'widgets/Chat/Message'

interface Props {
  readonly channelId: IChannel['id']
}

const List: React.FC<Props> = ({ channelId }) => {
  const dispatch = useDispatch()
  const items = useSelector(selectItems)

  useEffect(() => {
    dispatch(fetchAllAndSubscribe(channelId))

    return () => {
      dispatch(unsubscribe())
    }
  }, [ dispatch, channelId ])

  return (
    <Box sx={{
      position: 'absolute',
      display: 'flex',
      flexDirection: 'column',
      gap: 4,
      top: 0,
      left: 0,
      right: 0,
      bottom: 0,
      overflowY: 'scroll',
      overflowX: 'hidden',
      overflowAnchor: 'none',
      alignItems: 'stretch',
      width: '100%',
      height: 'calc(100% - 150px)',
      mt: 10,
      pl: 2
    }}>
      { items.map(
        message =>
          <Message
            key={ message.id }
            id={ message.id }
            content={ message.content }
            author={ message.author.name }
            date={ message.createdAt }
          />
      )}
    </Box>
  )
}

export default List
