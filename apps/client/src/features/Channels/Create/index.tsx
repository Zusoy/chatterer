import React, { useCallback, useEffect, useState } from 'react'
import { Dialog, Card, CardBody } from '@material-tailwind/react'
import {
  type CreatePayload,
  create,
  selectIsCreated,
  selectIsCreating,
  clear,
  selectIsError
} from 'features/Channels/Create/slice'
import { useDispatch, useSelector } from 'react-redux'
import toast, { ToastType } from 'services/toaster'
import { type Station } from 'models/station'
import Input from 'widgets/Forms/Input'
import Textarea from 'widgets/Forms/Textarea'
import Button from 'widgets/Buttons/Button'
import Typography from 'widgets/Texts/Typography'

type Props = {
  handler: React.Dispatch<React.SetStateAction<boolean>>,
  opened: boolean
  stationId: Station['id']
}

const Create: React.FC<Props> = ({ handler, opened, stationId }) => {
  const dispatch = useDispatch()
  const [name, setName] = useState<string>('')
  const isCreating = useSelector(selectIsCreating)
  const isCreated = useSelector(selectIsCreated)
  const isError = useSelector(selectIsError)

  const reset = useCallback(() => {
    setName('')
    dispatch(clear())
  }, [name, dispatch])

  const onSubmitHandler: React.FormEventHandler<HTMLFormElement> = e => {
    e.preventDefault()
    const data = new FormData(e.currentTarget)

    const payload: CreatePayload = {
      stationId: stationId,
      name: data!.get('name') as string,
      description: data.get('description')?.toString() || null
    }

    dispatch(create(payload))
  }

  useEffect(() => {
    if (!isCreated) {
      return
    }

    toast({
      content: 'Channel created !',
      type: ToastType.Success
    })
    handler(false)
    reset()
  }, [isCreated, handler])

  useEffect(() => {
    if (!isError) {
      return
    }

    toast({
      content: 'Error happened during channel creation',
      type: ToastType.Error
    })
    reset()
  }, [isError])

  return (
    <Dialog open={opened} size='xs' className='transition-all ease-out' handler={handler}>
      <Card className="mx-auto w-full">
        <CardBody className="flex flex-col gap-4">
          <Typography variant='h3' className='text-center'>Add channel</Typography>
          <form onSubmit={onSubmitHandler} className='flex flex-col gap-4'>
            <Input
              name='name'
              label='Name'
              value={name}
              onChange={e => setName(e.target.value)}
              required
            />
            <Textarea
              name='description'
              label='Description'
            />
            <div className='flex flex-col gap-2'>
              <Button
                type='submit'
                className='w-100 flex items-center justify-center'
                disabled={!name.length}
                loading={isCreating}
              >
                Create
              </Button>
              <Button
                className='w-100 flex items-center justify-center'
                variant='outlined'
                onClick={() => handler(false)}
              >
                Cancel
              </Button>
            </div>
          </form>
        </CardBody>
      </Card>
    </Dialog>
  )
}

export default Create
