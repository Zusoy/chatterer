import React from 'react'
import { ThemeProvider as MaterialProvider } from '@material-tailwind/react'

type ThemeProps = React.PropsWithChildren

const Theme: React.FC<ThemeProps> = ({ children }) =>
  <MaterialProvider>
    {children as any}
  </MaterialProvider>

export default Theme
