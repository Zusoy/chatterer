import React from 'react'
import Firewall from 'features/Firewall'
import AuthenticatedApp from 'AuthenticatedApp'
import Theme from 'app/Theme'

const App: React.FC = () =>
  <>
    <Theme>
      <Firewall>
        <AuthenticatedApp />
      </Firewall>
    </Theme>
  </>

export default App
