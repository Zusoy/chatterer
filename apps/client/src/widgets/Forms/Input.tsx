import React, { RefAttributes } from 'react'
import { Input as MatInput, type InputProps } from '@material-tailwind/react'

export type Props = InputProps & RefAttributes<HTMLInputElement>

const Input: React.FC<Props> = ({ ...props }) =>
  <MatInput
    crossOrigin={undefined}
    {...props}
  />

export default Input
