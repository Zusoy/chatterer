import React from 'react'
import { Provider as StoreProvider } from 'react-redux'
import { ThemeProvider } from 'styled-components'
import { store } from 'app/store'
import { theme } from 'app/theme'

interface Props {
  readonly children: React.ReactNode
}

const Provider: React.FC<Props> = ({ children }) =>
  <StoreProvider store={ store }>
    <ThemeProvider theme={ theme }>
      { children }
    </ThemeProvider>
  </StoreProvider>

export default Provider
