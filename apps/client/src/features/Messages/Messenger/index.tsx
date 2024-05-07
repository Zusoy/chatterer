import React, { useState } from 'react'
import { type Channel } from 'models/channel'
import { useDispatch, useSelector } from 'react-redux'
import { IconButton } from '@material-tailwind/react'
import { selectIsPosting, post } from 'features/Messages/Messenger/slice'
import Textarea from 'widgets/Forms/Textarea'

type Props = {
  channelId: Channel['id']
}

const Messenger: React.FC<Props> = ({ channelId }) => {
  const [content, setContent] = useState<string>('')
  const isPosting = useSelector(selectIsPosting)
  const dispatch = useDispatch()

  const onKeyDownHandler: React.KeyboardEventHandler<HTMLElement> = e => {
    if (e.key !== 'Enter' || e.shiftKey || !content.trim().length) {
      return
    }

    e.preventDefault()
    onSubmitHandler(e)
  }

  const onSubmitHandler: React.FormEventHandler = e => {
    e.preventDefault()

    dispatch(post({ channelId, content }))
    setContent('')
  }

  return (
    <div className='flex w-full flex-row items-center gap-2 border border-gray-900/10 bg-gray-900/5 p-2'>
      <form className='flex w-full' onSubmit={onSubmitHandler}>
        <Textarea
          name='message'
          value={content}
          rows={1}
          resize={false}
          placeholder='Say something...'
          className='min-h-full !border-0 focus:border-transparent active:bg-blue-gray-50'
          containerProps={{
            className: "grid h-full",
          }}
          labelProps={{
            className: "before:content-none after:content-none",
          }}
          onChange={e => setContent(e.target.value)}
          onKeyDown={onKeyDownHandler}
          disabled={isPosting}
        />
        <div>
          <IconButton
            variant='text'
            className='rounded-full'
            type='submit'
            disabled={!content.trim().length}
            placeholder={undefined}
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              strokeWidth={2}
              className="h-5 w-5"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"
              />
            </svg>
          </IconButton>
        </div>
      </form>
    </div>
  )
}

export default Messenger
