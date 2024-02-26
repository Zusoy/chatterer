import React from 'react'
import { Button, Input, Textarea } from '@material-tailwind/react'

const Create: React.FC = () => {
  const onSubmitHandler: React.FormEventHandler<HTMLFormElement> = e => {
    e.preventDefault()

    const data = new FormData(e.currentTarget)
  }

  return (
    <form onSubmit={onSubmitHandler}>
      <div className='flex w-full flex-col gap-8'>
        <div className='mt-9'>
          <Input
            name='name'
            label='Name'
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
        <Button type='submit'>Create</Button>
      </div>
    </form>
  )
}

export default Create
