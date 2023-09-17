import React, { useCallback, useState } from 'react'
import { useSelector } from 'react-redux'
import { selectCurrentStation } from 'features/Stations/List/slice'
import { selectCurrentChannel } from 'features/Channels/List/slice'
import Box from '@mui/material/Box'
import Toolbar from '@mui/material/Toolbar'
import Header from 'features/Header'
import Sidebar from 'features/Sidebar'
import Stations from 'features/Stations/List'
import Channels from 'features/Channels/List'
import Messages from 'features/Messages/List'
import Messenger from 'features/Messages/Messenger'

const AuthenticatedApp: React.FC = () => {
  const [ sidebarOpen, setSidebarOpen ] = useState<boolean>(false)
  const station = useSelector(selectCurrentStation)
  const channel = useSelector(selectCurrentChannel)

  const toggleSidebar = useCallback(() => {
    setSidebarOpen(!sidebarOpen)
  }, [ sidebarOpen, setSidebarOpen ])

  return(
    <Box sx={{ display: 'flex', minHeight: '100vh' }}>
      <Header open={ sidebarOpen } toggleSidebar={ toggleSidebar }></Header>
      <Sidebar open={ sidebarOpen } toggleSidebar={ toggleSidebar }>
        <Stations />
      </Sidebar>
      { station &&
        <Sidebar open={ true } toggleSidebar={ () => {} }>
          <Channels stationId={ station.id } />
        </Sidebar>
      }
      <Box component='main' sx={{ flexGrow: 1, overflow: 'auto' }} position='relative'>
        { channel &&
          <>
            <Toolbar />
            <Box
              sx={{
                display: 'flex',
                flexDirection: 'column',
                bottom: 0,
                justifyContent: 'center',
                alignItems: 'center',
                width: '100%'
            }}>
              <Messages channelId={ channel.id } />
              <Messenger channelId={ channel.id } />
            </Box>
          </>
        }
      </Box>
    </Box>
  )
}

export default AuthenticatedApp
