import React from 'react'
import { useDispatch } from 'react-redux'
import { logout } from 'features/Me/Logout/slice'
import {
  Dialog,
  DialogHeader,
  DialogBody,
  DialogFooter,
} from '@material-tailwind/react'
import Button from 'widgets/Buttons/Button'

type Props = {
  handler: React.Dispatch<React.SetStateAction<boolean>>,
  opened: boolean
}

const Logout: React.FC<Props> = ({ opened, handler }) => {
  const dispatch = useDispatch()

  const onSubmitHandler: React.FormEventHandler<HTMLFormElement> = e => {
    e.preventDefault()
    dispatch(logout())
  }

  return (
    <Dialog open={opened} handler={handler}>
      <form onSubmit={onSubmitHandler}>
        <DialogHeader>Logout</DialogHeader>
        <DialogBody>
          Are you sure to logout from your account ?
        </DialogBody>
        <DialogFooter>
          <Button
            variant='text'
            className='mr-1'
            onClick={() => handler(false)}
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
