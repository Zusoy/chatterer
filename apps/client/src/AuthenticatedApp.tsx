import React, { useState } from 'react'
import Navbar from 'features/Navbar'
import Stations from 'features/Stations/List'
import Channels from 'features/Channels/List'
import Messages from 'features/Messages/List'
import Messenger from 'features/Messages/Messenger'
import Logout from 'features/Me/Logout'
import JoinOrCreateStation from 'features/Stations/JoinOrCreateDialog'
import { selectCurrentStationId } from 'features/Stations/List/slice'
import { selectCurrentChannel } from 'features/Channels/List/slice'
import { useSelector } from 'react-redux'

const AuthenticatedApp: React.FC = () => {
  const [stationModalOpened, setStationModalOpened] = useState<boolean>(false)
  const [logoutModalOpened, setLogoutModalOpened] = useState<boolean>(false)
  const currentStationId = useSelector(selectCurrentStationId)
  const currentChannelId = useSelector(selectCurrentChannel)

  return (
    <main className='flex-grow absolute'>
      {logoutModalOpened &&
        <Logout onCancel={() => setLogoutModalOpened(false)} />
      }
      {stationModalOpened &&
        <JoinOrCreateStation onCancel={() => setStationModalOpened(false)} />
      }
      <div className='flex flex-col'>
        <Navbar
          onLogout={() => setLogoutModalOpened(true)}
        />
        <div className='flex flex-row'>
          <aside className='flex flex-col w-20 shadow-lg bg-white h-[calc(100vh-78px)] gap-1 items-center relative'>
            <Stations onNewClick={() => setStationModalOpened(true)} />
          </aside>
          {!!currentStationId &&
            <div className='flex flex-row w-full relative'>
              <aside className='pt-1'>
                <Channels stationId={currentStationId} />
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
          }
        </div>
      </div>
    </main>
  )
}

export default AuthenticatedApp
