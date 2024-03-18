import React, { useEffect } from 'react'
import { type Channel } from 'models/channel'
import { useDispatch, useSelector } from 'react-redux'
import { fetchAllAndSubscribe, selectIsFetching, selectItems, unsubscribe } from 'features/Messages/List/slice'
import Fallback from 'features/Messages/List/Fallback'
import Message from 'widgets/Message/Message'

type Props = {
  channelId: Channel['id']
}

const List: React.FC<Props> = ({ channelId }) => {
  const dispatch = useDispatch()
  const isFetching = useSelector(selectIsFetching)
  const items = useSelector(selectItems)

  useEffect(() => {
    dispatch(fetchAllAndSubscribe(channelId))

    return () => {
      dispatch(unsubscribe())
    }
  }, [dispatch, channelId])

  return (
    <div className='flex flex-col gap-2 m-2 overflow-x-hidden'>
      {isFetching
        ? <Fallback prediction={10} />
        : items.map(
          message =>
            <Message
              key={message.id}
              id={message.id}
              authorName={message.author.name}
              content={message.content}
              createdAt={message.createdAt}
            />
        )
      }
    </div>
  )
}

export default List
