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
    <Main>
      <ContentGrid>
        <HeaderContainer>
          Header
        </HeaderContainer>
        <SidebarContainer>
          Sidebar
        </SidebarContainer>
        <ContentContainer>
          Content
        </ContentContainer>
      </ContentGrid>
    </Main>
  </Background>

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

const ContentGrid = styled.section`
  display: grid;
  grid-template-rows: 50px 1fr;
  grid-template-columns: 0.5fr 9fr;
  grid-template-areas:
    "header header"
    "sidebar content"
`

const HeaderContainer = styled.header(({ theme }) => `
  grid-area: header;
  background-color: ${ theme.colors.lightDark };
`)

const SidebarContainer = styled.aside(({ theme }) => `
  grid-area: sidebar;
  background-color: ${ theme.colors.dark50 };
  height: calc(100vh - 50px);
`)

const ContentContainer = styled.div(({ theme }) => `
  background-color: ${ theme.colors.dark25 };
`)

export default App
