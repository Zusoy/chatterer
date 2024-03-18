import React from 'react'
import { Typography as MatTypo, type TypographyProps } from '@material-tailwind/react'

export type Props = TypographyProps

const Typography: React.FC<Props> = ({ children, ...props }) =>
  <MatTypo {...props} placeholder={undefined}>
    {children}
  </MatTypo>

export default Typography
