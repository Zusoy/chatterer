import React from 'react'
import { Button as MatButton, type ButtonProps } from '@material-tailwind/react'

export type Props = ButtonProps

const Button: React.FC<Props> = ({ children, ...props }) =>
  <MatButton {...props}>
    {children}
  </MatButton>

export default Button
