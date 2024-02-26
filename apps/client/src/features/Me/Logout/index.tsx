import React from 'react'
import { useDispatch } from 'react-redux'
import {
  Button,
  Dialog,
  DialogHeader,
  DialogBody,
  DialogFooter,
} from '@material-tailwind/react'
import { logout } from 'features/Me/Logout/slice'

type Props = {
  onCancel: React.MouseEventHandler
}

const Logout: React.FC<Props> = ({ onCancel }) => {
  const dispatch = useDispatch()

  const onSubmitHandler: React.FormEventHandler<HTMLFormElement> = e => {
    e.preventDefault()
    dispatch(logout())
  }

  return (
    <Dialog open={true}>
      <form onSubmit={onSubmitHandler}>
        <DialogHeader>Logout</DialogHeader>
        <DialogBody>
          Are you sure to logout from your account ?
        </DialogBody>
        <DialogFooter>
          <Button
            variant='text'
            className='mr-1'
            onClick={onCancel}
          >
            <span>Cancel</span>
          </Button>
          <Button variant='gradient' type='submit'>
            <span>Confirm</span>
          </Button>
        </DialogFooter>
      </form>
    </Dialog>
  )
}

export default Logout
