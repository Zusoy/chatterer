import React, { Suspense, lazy } from 'react'
import Theme from 'app/Theme'
import Firewall from 'features/Firewall'
import FullPageLoader from 'widgets/FullPageLoader'

const AuthenticatedApp = lazy(() => import('AuthenticatedApp'))

const App: React.FC = () =>
  <>
    <Theme>
      <Firewall>
        <Suspense fallback={ <FullPageLoader /> }>
          <AuthenticatedApp />
        </Suspense>
      </Firewall>
    </Theme>
  </>

export default App
