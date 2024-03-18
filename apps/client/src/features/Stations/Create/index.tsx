import React, { useEffect, useCallback, useState } from 'react'
import { create, clear, selectIsCreated, type CreatePayload, selectIsCreating, selectIsError } from 'features/Stations/Create/slice'
import { useDispatch, useSelector } from 'react-redux'
import Input from 'widgets/Forms/Input'
import Textarea from 'widgets/Forms/Textarea'
import Button from 'widgets/Buttons/Button'
import toast, { ToastType } from 'services/toaster'

type Props = {
  onCreated: () => void
}

const Create: React.FC<Props> = ({ onCreated }) => {
  const dispatch = useDispatch()
  const [name, setName] = useState<string>('')
  const isCreated = useSelector(selectIsCreated)
  const isError = useSelector(selectIsError)
  const isCreating = useSelector(selectIsCreating)

  const reset = useCallback(() => {
    setName('')
    dispatch(clear())
  }, [name, dispatch])

  useEffect(() => {
    if (!isCreated) {
      return
    }

    onCreated()
    toast({
      content: 'Station created !',
      type: ToastType.Success
    })

    return () => {
      reset()
    }
  }, [isCreated])

  useEffect(() => {
    if (!isError) {
      return;
    }

    toast({
      content: 'An error happened during station creation',
      type: ToastType.Error
    })
    reset()
  }, [isError])

  const onSubmitHandler: React.FormEventHandler<HTMLFormElement> = e => {
    e.preventDefault()

    const data = new FormData(e.currentTarget)
    const payload: CreatePayload = {
      name: data!.get('name') as string,
      description: data.get('description')?.toString() || null
    }

    dispatch(create(payload))
  }

  return (
    <form onSubmit={onSubmitHandler}>
      <div className='flex w-full flex-col gap-8'>
        <div className='mt-9'>
          <Input
            name='name'
            label='Name'
            value={name}
            onChange={e => setName(e.target.value)}
            placeholder='The station name'
            size='lg'
            required
          />
        </div>
        <Textarea
          name='description'
          label='Description'
          rows={2}
        />
        <Button
          type='submit'
          className='w-100 flex items-center justify-center'
          loading={isCreating}
          disabled={name.length <= 0}
        >
          Create
        </Button>
      </div>
    </form>
  )
}

export default Create
