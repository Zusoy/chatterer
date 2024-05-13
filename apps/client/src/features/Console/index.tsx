import React, { useCallback, useEffect, useMemo, useState } from 'react'
import { type RootState } from 'app/store'
import { type ICommand } from 'features/Console/ICommand'
import {
  Dialog,
  Card,
  CardBody,
  List,
  ListItem
} from '@material-tailwind/react'
import { useStore } from 'react-redux'
import Typography from 'widgets/Texts/Typography'
import Prompt from 'features/Console/Prompt'
import commands from 'features/Console/Commands/provider'

type Props = {
  handler: React.Dispatch<React.SetStateAction<boolean>>,
  opened: boolean
}

const Console: React.FC<Props> = ({ opened, handler }) => {
  const store = useStore<RootState>()
  const [prompt, setPrompt] = useState<string>('')
  const [cursor, setCursor] = useState<number>(0)
  const [registeredCommands, _setRegisteredCommands] = useState<ICommand[]>(commands)

  const commandsInitialized = useMemo(() => {
    return registeredCommands.length > 0
  }, [registeredCommands])

  const filteredCommands = useMemo(() => {
    if (!prompt.length) {
      return []
    }

    return commands
      .filter(cmd => cmd.getConfig().label.toLowerCase().includes(prompt.toLowerCase()))
  }, [commands, prompt])

  const cursorNext = useCallback(() => {
    if (filteredCommands.length <= 1) {
      return
    }

    setCursor(c => c === filteredCommands.length -1 ? 0 : c + 1)
  }, [cursor, filteredCommands])

  const cursorPrevious = useCallback(() => {
    if (filteredCommands.length <= 1) {
      return
    }

    setCursor(c => c === 0 ? filteredCommands.length - 1 : c - 1)
  }, [cursor, filteredCommands])

  const processSelectedCmd = useCallback(() => {
    return filteredCommands[cursor]?.process(store.dispatch, store.getState())
  }, [cursor, filteredCommands, store])

  useEffect(() => {
    if (!opened) {
      setPrompt('')
      return
    }

    const cursorListener = (e: KeyboardEvent) => {
      if (e.key.toLowerCase() === 'arrowdown') {
        cursorNext()
        return
      }

      cursorPrevious()
    }

    document.addEventListener('keydown', cursorListener)

    return () => {
      document.removeEventListener('keydown', cursorListener)
    }
  }, [opened, filteredCommands])

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
          <Prompt
            value={prompt}
            handler={setPrompt}
            ready={commandsInitialized}
            onSubmit={processSelectedCmd}
          />
          <List className='transition-all ease-in-out'>
            {filteredCommands.map(
              (cmd, i) =>
                <ListItem
                  key={cmd.getConfig().tag}
                  onClick={() => cmd.process(store.dispatch, store.getState())}
                  className='flex flex-row items-center gap-2'
                  selected={cursor === i}
                >
                  {!!cmd.getConfig().icon && cmd.getConfig().icon}
                  <div className='flex flex-col gap-1'>
                    {cmd.getConfig().label}
                    {!!cmd.getConfig().description &&
                      <Typography variant='small'>{cmd.getConfig().description}</Typography>
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
