import React from 'react'
import { Puff as PuffLoader } from 'react-loader-spinner'

interface Props {
  readonly width: number
  readonly height: number
  readonly radius: number
  readonly color: string
}

const Puff: React.FC<Props> = ({ width, height, radius, color }) =>
  <PuffLoader
    width={ width }
    height={ height }
    radius={ radius }
    color={ color }
  />

export default Puff
