import React from 'react'
import {
  Card,
  CardHeader,
  CardBody,
  CardFooter
} from '@material-tailwind/react'
import { useDispatch } from 'react-redux'
import { authenticate } from 'features/Me/Authentication/slice'
import Input from 'widgets/Forms/Input'
import Button from 'widgets/Buttons/Button'
import Typography from 'widgets/Texts/Typography'

const Authenticate: React.FC = () => {
  const dispatch = useDispatch()

  const onSubmitHandler: React.FormEventHandler = e => {
    e.preventDefault()

    const data = new FormData(e.currentTarget as HTMLFormElement)
    const [username, password] = [
      data.get('username')?.toString() || '',
      data.get('password')?.toString() || ''
    ]

    dispatch(authenticate({ username, password }))
  }

  return (
    <div className='flex h-screen'>
      <Card className="w-96 m-auto" placeholder={undefined}>
        <form onSubmit={onSubmitHandler}>
          <CardHeader
            variant="gradient"
            color="gray"
            className="mb-4 grid h-28 place-items-center"
            placeholder={undefined}
          >
            <Typography variant="h4" color="white">Welcome</Typography>
          </CardHeader>
          <CardBody className="flex flex-col gap-4" placeholder={undefined}>
            <Input name='username' label="Email" placeholder='Email' size="lg" required />
            <Input name='password' label="Password" placeholder='Password' size="lg" type='password' required />
          </CardBody>
          <CardFooter className="pt-0" placeholder={undefined}>
            <Button variant="gradient" type='submit' fullWidth>
              Sign In
            </Button>
          </CardFooter>
        </form>
      </Card>
    </div>
  )
}

export default Authenticate
