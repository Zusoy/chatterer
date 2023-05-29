import React from 'react'
import GlobalStyle from 'app/GlobalStyle'
import styled from 'styled-components'
import Firewall from 'features/Firewall'

const App: React.FC = () =>
  <>
    <GlobalStyle />
    <Firewall>
      <AuthenticatedApp />
    </Firewall>
  </>

const AuthenticatedApp: React.FC = () =>
  <Background>
    <main>
      <p>Welcome</p>
    </main>
  </Background>

const Background = styled.div(({ theme }) => `
  min-height: 100vh;
  background-color: ${ theme.colors.dark75 };
`)

export default App
