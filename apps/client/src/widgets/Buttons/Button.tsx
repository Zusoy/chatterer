import React, { type RefAttributes } from 'react'
import { Button as MatButton, type ButtonProps } from '@material-tailwind/react'

export type Props = ButtonProps & RefAttributes<HTMLButtonElement>

const Button: React.FC<Props> = ({ children, ...props }) =>
  <MatButton {...props}>
    {children}
  </MatButton>

export default Button
