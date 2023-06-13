import { createGlobalStyle } from 'styled-components'
import { Theme } from 'app/theme'

const GlobalStyle = createGlobalStyle<{ theme: Theme }>(({ theme }) => `
  html {
    font-family: 'Helvetica';
  }

  body {
    margin: 0;
    overflow: hidden;
  }
`)

export default GlobalStyle
