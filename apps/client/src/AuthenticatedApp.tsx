import React, { useEffect, useState } from 'react'
import Navbar from 'features/Navbar'
import Stations from 'features/Stations/List'
import Channels from 'features/Channels/List'
import Messages from 'features/Messages/List'
import Messenger from 'features/Messages/Messenger'
import LogoutModal from 'features/Me/Logout'
import ChannelCreate from 'features/Channels/Create'
import JoinOrCreateStation from 'features/Stations/JoinOrCreateDialog'
import Console from 'features/Console'
import { selectCurrentStation } from 'features/Stations/slice'
import { selectCurrentChannel } from 'features/Channels/slice'
import { useSelector } from 'react-redux'
import { ToastContainer } from 'react-toastify'

const AuthenticatedApp: React.FC = () => {
  const [stationModalOpened, setStationModalOpened] = useState<boolean>(false)
  const [logoutModalOpened, setLogoutModalOpened] = useState<boolean>(false)
  const [newChannelModalOpened, setNewChannelModalOpened] = useState<boolean>(false)
  const [consoleOpened, setConsoleOpened] = useState<boolean>(false)
  const currentStation = useSelector(selectCurrentStation)
  const currentChannelId = useSelector(selectCurrentChannel)

  useEffect(() => {
    const consoleListener = (e: KeyboardEvent) => {
      if (e.code.toLowerCase() === 'keyp' && e.ctrlKey && e.shiftKey) {
        e.preventDefault()
        setConsoleOpened(opened => !opened)
      }
    }

    document.addEventListener('keydown', consoleListener)

    return () => {
      document.removeEventListener('keydown', consoleListener)
    }
  }, [])

  return (
    <main className='flex-grow absolute'>
      <React.Fragment>
        <LogoutModal
          opened={logoutModalOpened}
          handler={setLogoutModalOpened}
        />
        <JoinOrCreateStation
          opened={stationModalOpened}
          handler={setStationModalOpened}
        />
        <Console
          opened={consoleOpened}
          handler={setConsoleOpened}
        />
        <ToastContainer style={{ zIndex: 99999 }} />
      </React.Fragment>
      <div className='flex flex-col'>
        <Navbar
          onLogout={() => setLogoutModalOpened(true)}
        />
        <div className='flex flex-row'>
          <aside className='flex flex-col w-20 shadow-lg bg-white h-[calc(100vh-78px)] gap-1 items-center relative'>
            <Stations onNewClick={() => setStationModalOpened(true)} />
          </aside>
          {!!currentStation &&
            <React.Fragment>
              <ChannelCreate
                stationId={currentStation.id}
                handler={setNewChannelModalOpened}
                opened={newChannelModalOpened}
              />
              <div className='flex flex-row w-full relative'>
                <aside>
                  <Channels
                    stationId={currentStation.id}
                    stationName={currentStation.name}
                    onNewChannel={() => setNewChannelModalOpened(true)}
                  />
                </aside>
                {!!currentChannelId &&
                  <div className='flex flex-col h-full w-full'>
                    <div className='w-full h-[calc(100vh-150px)] overflow-y-scroll'>
                      <Messages channelId={currentChannelId} />
                    </div>
                    <Messenger channelId={currentChannelId} />
                  </div>
                }
              </div>
            </React.Fragment>
          }
        </div>
      </div>
    </main>
  )
}

export default AuthenticatedApp
