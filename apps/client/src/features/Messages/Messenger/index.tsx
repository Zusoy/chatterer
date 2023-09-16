import React, { useState } from 'react'
import { IChannel } from 'models/channel'
import { useDispatch, useSelector } from 'react-redux'
import { selectIsPosting, post } from 'features/Messages/Messenger/slice'
import Box from '@mui/material/Box'
import TextField from '@mui/material/TextField'

interface Props {
  readonly channelId: IChannel['id']
}

const Messenger: React.FC<Props> = ({ channelId }) => {
  const [ content, setContent ] = useState<string>('')
  const dispatch = useDispatch()
  const isPosting = useSelector(selectIsPosting)

  const onKeyDownHandler: React.KeyboardEventHandler<HTMLElement> = e => {
    if (e.key !== 'Enter' || e.shiftKey || !content.trim().length) {
      return
    }

    e.preventDefault()
    onSubmitHandler(e)
  }

  const onSubmitHandler: React.FormEventHandler = e => {
    e.preventDefault()

    dispatch(post({ content, channelId }))
    setContent('')
  }

  return (
    <Box
      component='form'
      onSubmit={ onSubmitHandler }
      sx={{ mb: 2, width: '95%', position: 'absolute', bottom: 0 }}
    >
      <TextField
        autoFocus
        fullWidth
        hiddenLabel
        multiline
        name='content'
        variant='filled'
        disabled={ isPosting }
        onChange={ e => setContent(e.target.value) }
        onKeyDown={ onKeyDownHandler }
        value={ content }
        placeholder='Say something'
      />
    </Box>
  )
}

export default Messenger
