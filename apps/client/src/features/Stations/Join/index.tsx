import React from 'react'
import Button from 'widgets/Buttons/Button'
import Input from 'widgets/Forms/Input'
import Typography from 'widgets/Texts/Typography'

const Join: React.FC = () => {
  const onSubmitHandler: React.FormEventHandler<HTMLFormElement> = e => {
    e.preventDefault()
    console.log(e)
  }

  return (
    <form onSubmit={onSubmitHandler}>
      <div className='flex w-full flex-col gap-10'>
        <div className='mt-9'>
          <Input
            name='token'
            label='Invitation token'
            placeholder='Type your invitation token'
            size='lg'
            required
          />
        </div>
        <div className='flex flex-col gap-2'>
          <Typography variant='lead'>What's invitation token ?</Typography>
          <Typography variant='paragraph'>
            Invitation token allow you to join a station.
            You can get one by asking at the station's administrator
          </Typography>
        </div>
        <Button
          type='submit'
          className='w-100 flex items-center justify-center'
        >
          Join
        </Button>
      </div>
    </form>
  )
}

export default Join
