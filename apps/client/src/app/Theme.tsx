import React, { PropsWithChildren, useMemo, useState } from 'react'
import { createTheme, ThemeProvider } from '@mui/material/styles'
import CssBaseline from '@mui/material/CssBaseline'

export type ThemeMode = 'light'|'dark'
export type ThemeModeToggler = () => void
export const ThemeContext = React.createContext<{ toggleThemeMode: ThemeModeToggler}>({ toggleThemeMode: () => {}})

const Theme: React.FC<PropsWithChildren> = ({ children }) => {
  const [ themeMode, setThemeMode ] = useState<ThemeMode>('dark')

  const themeModeToggler = useMemo(
    () => ({
      toggleThemeMode: () => {
        setThemeMode(current => current === 'light' ? 'dark': 'light')
      }
    }),
    []
  )

  const theme = useMemo(
    () => createTheme({
      palette: {
        mode: themeMode
      }
    }),
    [ themeMode ]
  )

  return (
    <ThemeContext.Provider value={ themeModeToggler }>
      <ThemeProvider theme={ theme }>
        <CssBaseline />
        { children }
      </ThemeProvider>
    </ThemeContext.Provider>
  )
}

export default Theme
