import React, { type RefAttributes } from 'react'
import { Typography as MatTypo, type TypographyProps } from '@material-tailwind/react'

export type Props = TypographyProps & RefAttributes<HTMLButtonElement>

const Typography: React.FC<Props> = ({ children, ...props }) =>
  <MatTypo {...props}>
    {children}
  </MatTypo>

export default Typography
