import React from 'react'
import Firewall from 'features/Firewall'
import AuthenticatedApp from 'AuthenticatedApp'
import { ThemeProvider } from '@mui/material/styles'
import CssBaseline from '@mui/material/CssBaseline'
import theme from 'app/theme'

const App: React.FC = () =>
  <>
    <ThemeProvider theme={ theme }>
      <CssBaseline />
      <Firewall>
        <AuthenticatedApp />
      </Firewall>
    </ThemeProvider>
  </>

export default App
