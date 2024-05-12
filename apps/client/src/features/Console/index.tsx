import React, { useMemo, useState } from 'react'
import { type RootState } from 'app/store'
import {
  Dialog,
  Card,
  CardBody,
  List,
  ListItem
} from '@material-tailwind/react'
import Input from 'widgets/Forms/Input'
import { useStore } from 'react-redux'
import { type Command } from 'features/Console/slice'
import { logout } from 'features/Me/Logout/slice'
import { ArrowRightStartOnRectangleIcon } from '@heroicons/react/24/outline'
import Typography from 'widgets/Texts/Typography'

type Props = {
  handler: React.Dispatch<React.SetStateAction<boolean>>,
  opened: boolean
}

const Console: React.FC<Props> = ({ opened, handler }) => {
  const store = useStore<RootState>()
  const [prompt, setPrompt] = useState<string>('')
  const [commands, _setCommands] = useState<Command[]>([
    {
      tag: 'logout',
      label: 'Logout',
      description: 'logout from chatterer',
      icon: <ArrowRightStartOnRectangleIcon strokeWidth={2.5} className={`h-3.5 w-3.5`} />,
      process: (dispatch, _state) => {
        dispatch(logout())
      }
    }
  ])

  const initialized = useMemo(() => {
    return commands.length > 0
  }, [commands])

  const filteredCommands = useMemo(() => {
    if (!prompt.length) {
      return []
    }

    return commands
      .filter(cmd => cmd.label.toLowerCase().includes(prompt.toLowerCase()))
  }, [commands, prompt])

  return (
    <Dialog
      open={opened}
      handler={handler}
      size='sm'
      className='transition-all ease-out'
      animate={{
        mount: { scale: 1, y: 0 },
        unmount: { scale: 0.9, y: -100 },
      }}
    >
      <Card className="mx-auto w-full">
        <CardBody className="flex flex-col gap-0 !p-2">
          <Input
            autoFocus
            size='lg'
            className='w-full !bg-blue-gray-50'
            placeholder='Search...'
            label='Search'
            onChange={e => setPrompt(e.target.value)}
            disabled={!initialized}
            value={prompt}
            icon={
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
                <path strokeLinecap="round" strokeLinejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
              </svg>
            }
          />
          <List className='transition-all ease-in-out'>
            {filteredCommands.map(
              cmd =>
                <ListItem
                  key={cmd.tag}
                  onClick={() => cmd.process(store.dispatch, store.getState())}
                  className='flex flex-row items-center gap-2'
                >
                  {!!cmd.icon && cmd.icon}
                  <div className='flex flex-col gap-1'>
                    {cmd.label}
                    {!!cmd.description &&
                      <Typography variant='small'>{cmd.description}</Typography>
                    }
                  </div>
                </ListItem>
            )}
          </List>
        </CardBody>
      </Card>
    </Dialog>
  )
}

export default Console
