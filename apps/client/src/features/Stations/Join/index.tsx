import React from 'react'
import Dialog from '@mui/material/Dialog'
import DialogTitle from '@mui/material/DialogTitle'
import DialogContent from '@mui/material/DialogContent'
import DialogContentText from '@mui/material/DialogContentText'
import DialogActions from '@mui/material/DialogActions'
import TextField from '@mui/material/TextField'
import Button from '@mui/material/Button'
import { useDispatch } from 'react-redux'
import { join } from 'features/Stations/Join/slice'

interface Props {
  readonly onCancel: React.MouseEventHandler
}

const Join: React.FC<Props> = ({ onCancel }) => {
  const dispatch = useDispatch()

  const onSubmitHandler: React.FormEventHandler<HTMLFormElement> = e => {
    e.preventDefault()

    const data = new FormData(e.currentTarget)
    const token = data.get('token')

    if (!token) {
      return
    }

    dispatch(join({ token: token.toString() }))
  }

  return (
    <Dialog open={ true } fullWidth>
      <DialogTitle>Join a station</DialogTitle>
      <form onSubmit={ onSubmitHandler }>
        <DialogContent dividers>
          <DialogContentText mb={ 2 }>
            Type your station invitation here to join an existing station
          </DialogContentText>
          <TextField
            autoFocus
            fullWidth
            required
            variant='filled'
            label='Invitation'
            name='token'
          />
        </DialogContent>
        <DialogActions>
          <Button onClick={ onCancel }>Cancel</Button>
          <Button type='submit'>Join</Button>
        </DialogActions>
      </form>
    </Dialog>
  )
}

export default Join
