import React, { Suspense, lazy } from 'react'
import Theme from 'app/Theme'
import Firewall from 'features/Firewall'
import Loader from 'widgets/FullpageLoader'

const AuthenticatedApp = lazy(() => import('AuthenticatedApp'))

const App: React.FC = () =>
  <React.Fragment>
    <Theme>
      <Firewall>
        <Suspense fallback={<Loader />}>
          <AuthenticatedApp />
        </Suspense>
      </Firewall>
    </Theme>
  </React.Fragment>

export default App
