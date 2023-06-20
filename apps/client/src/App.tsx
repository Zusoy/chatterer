import React from 'react'
import GlobalStyle from 'app/GlobalStyle'
import Firewall from 'features/Firewall'
import Stations from 'features/Stations/List'
import Channels from 'features/Channels/List'
import Messages from 'features/Messages/List'
import Message from 'features/Messages/Create'
import StationControl from 'features/StationControl'
import Logout from 'features/Me/Logout'
import { useSelector } from 'react-redux'
import { selectCurrentStation } from 'features/Stations/List/slice'
import { selectCurrentChannel } from 'features/Channels/List/slice'
import styled from 'styled-components'

const App: React.FC = () =>
  <>
    <GlobalStyle />
    <Firewall>
      <AuthenticatedApp />
    </Firewall>
  </>

const AuthenticatedApp: React.FC = () => {
  const station = useSelector(selectCurrentStation)
  const channel = useSelector(selectCurrentChannel)

  return (
    <Background>
      <Main>
        <ContentGrid hasStation={ !!station }>
          <HeaderContainer>
            <HeaderWrapper>
              <HeaderTitle>CHATTERER</HeaderTitle>
            </HeaderWrapper>
            <HeaderWrapper>
              <Logout />
            </HeaderWrapper>
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
            { channel &&
              <Content>
                <Messenger>
                  <Messages channel={ channel } />
                  <ControlContainer>
                    <Message channelId={ channel.id } />
                  </ControlContainer>
                </Messenger>
              </Content>
            }
          </ContentContainer>
        </ContentGrid>
      </Main>
  </Background>
  )
}

const Main = styled.div(({ theme }) => `
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
  display: flex;
  align-items: center;
  justify-content: space-between;
  grid-area: header;
  background-color: ${ theme.colors.lightDark };
`)

const HeaderWrapper = styled.div(({ theme }) => `
  display: flex;
  padding: ${ theme.gap.s };
`)

const HeaderTitle = styled.h3(({ theme }) => `
  padding: ${ theme.gap.s };
  color: ${ theme.colors.lightBlue };
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

const ContentContainer = styled.main(({ theme }) => `
  position: relative;
  background-color: ${ theme.colors.dark25 };
`)

const Content = styled.div(({ theme }) => `
  display: flex;
`)

const Messenger = styled.div`
  display: flex;
  flex-direction: column;
`

const ControlContainer = styled.div(({ theme }) => `
  position: absolute;
  bottom: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  background-color ${ theme.colors.dark25 };
`)

export default App
