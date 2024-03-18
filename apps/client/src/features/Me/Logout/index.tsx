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
    <Dialog open={opened} handler={handler} placeholder={undefined}>
      <form onSubmit={onSubmitHandler}>
        <DialogHeader placeholder={undefined}>Logout</DialogHeader>
        <DialogBody placeholder={undefined}>
          Are you sure to logout from your account ?
        </DialogBody>
        <DialogFooter placeholder={undefined}>
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
