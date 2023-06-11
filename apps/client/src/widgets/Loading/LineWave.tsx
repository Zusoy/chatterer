import React from 'react'
import { LineWave as LineWaveLoader } from 'react-loader-spinner'

interface Props {
  readonly width: number;
  readonly height: number;
  readonly color: string;
}

const LineWave: React.FC<Props> = ({ width, height, color }) =>
  <LineWaveLoader
    width={ width }
    height={ height }
    color={ color }
  />

export default LineWave
