import React from 'react'
import { Input as MatInput, type InputProps } from '@material-tailwind/react'

export type Props = InputProps

const Input: React.FC<Props> = ({ ...props }) =>
  <MatInput
    {...props}
  />

export default Input
