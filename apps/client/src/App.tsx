import React from 'react'
import GlobalStyle from 'app/GlobalStyle'
import Firewall from 'features/Firewall'
import Stations from 'features/Stations'
import Channels from 'features/Channels'
import StationControl from 'features/StationControl'
import styled from 'styled-components'
import { useSelector } from 'react-redux'
import { selectCurrentStation } from 'features/Stations/slice'

const App: React.FC = () =>
  <>
    <GlobalStyle />
    <Firewall>
      <AuthenticatedApp />
    </Firewall>
  </>

const AuthenticatedApp: React.FC = () => {
  const station = useSelector(selectCurrentStation)

  return (
    <Background>
      <Main>
        <ContentGrid hasStation={ !!station }>
          <HeaderContainer>
            Header
          </HeaderContainer>
          <SidebarContainer>
            <Stations />
          </SidebarContainer>
          { station &&
            <SecondarySidebarContainer>
              <StationControl station={ station } />
              <Channels stationId={ station.id } />
            </SecondarySidebarContainer>
          }
          <ContentContainer>
            Content
          </ContentContainer>
        </ContentGrid>
      </Main>
  </Background>
  )
}

const Main = styled.main(({ theme }) => `
  position: relative;
  color: ${ theme.colors.white };

  & > * {
    margin: 0;
  }
`)

const Background = styled.div(({ theme }) => `
  min-height: 100vh;
  background-color: ${ theme.colors.dark75 };
`)

const ContentGrid = styled.section<{ hasStation: boolean }>(({ hasStation }) => `
  display: grid;
  grid-template-rows: 50px 1fr;
  grid-template-columns: 0.5fr ${ hasStation ? '1fr' : '' } 8fr;
  grid-template-areas:
    "header header ${ hasStation ? 'header' : '' }"
    "sidebar ${ hasStation ? 'second-sidebar' : '' } content"
`)

const HeaderContainer = styled.header(({ theme }) => `
  grid-area: header;
  background-color: ${ theme.colors.lightDark };
`)

const SidebarContainer = styled.aside(({ theme }) => `
  grid-area: sidebar;
  background-color: ${ theme.colors.dark50 };
  height: calc(100vh - 50px);
`)

const SecondarySidebarContainer = styled.aside(({ theme }) => `
  grid-area: second-sidebar;
  background-color: ${ theme.colors.dark75 };
  height: calc(100vh - 50px);
`)

const ContentContainer = styled.div(({ theme }) => `
  background-color: ${ theme.colors.dark25 };
`)

export default App
