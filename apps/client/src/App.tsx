import React, { Suspense } from 'react';
import { routes } from 'app/routes';
import { BrowserRouter, Route, Routes } from 'react-router-dom'
import Firewall from 'features/Firewall';
import { useSelector } from 'react-redux';
import { selectAuthenticatedUser } from 'features/Me/slice';
import styled from 'styled-components';
import Stations from 'features/StationsSidebar/List';

const App: React.FC = () =>
  <BrowserRouter>
    <Suspense fallback={ <p>Loading...</p> }>
      <Routes>
        <Route path="*" element={ <></> } />
      </Routes>
      <Firewall>
        <AuthenticatedApp />
      </Firewall>
    </Suspense>
  </BrowserRouter>

const AuthenticatedApp: React.FC = () => {
  const me = useSelector(selectAuthenticatedUser)

  if (!me) {
    return <p>Loading...</p>
  }

  return (
    <>
      <Background>
        <Main>
          <Wrapper>
            <AppWrapper>
              <Sidebar>
                <Stations />
              </Sidebar>
              <Base>
                <Routes>
                  <Route path={ routes.homepage() } element={ <p>homepage</p> } />
                </Routes>
              </Base>
            </AppWrapper>
          </Wrapper>
        </Main>
      </Background>
    </>
  )
}

const Background = styled.div(({ theme }) => `
  min-height: 100vh;
  background-color: ${theme.colors.dark75};
  color: ${theme.colors.white};
`)

const Main = styled.main`
  display: flex;
`

const Wrapper = styled.div`
  position: absolute;
  height: 100%;
`

const AppWrapper = styled.div`
  display: flex;
  height: 100%;
`

const Sidebar = styled.nav(({ theme }) => `
  position: relative;
  width: 72px;
  flex-shrink: 0;
  background-color: ${theme.colors.dark80};
  height: auto;
`)

const Base = styled.div(({ theme }) => `
  position: relative;
  display: flex;
`)

export default App;
