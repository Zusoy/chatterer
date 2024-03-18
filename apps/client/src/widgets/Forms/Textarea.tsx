import React from 'react'
import { Textarea as MatTextarea, type TextareaProps } from '@material-tailwind/react'

export type Props = TextareaProps

const Textarea: React.FC<Props> = ({ ...props }) =>
  <MatTextarea
    {...props}
  />

export default Textarea
