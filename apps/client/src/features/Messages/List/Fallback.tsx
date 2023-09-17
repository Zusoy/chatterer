import React from 'react'
import Skeleton from 'widgets/Chat/Skeleton'

interface Props {
  readonly prediction: number
}

const Fallback: React.FC<Props> = ({ prediction }) =>
  <React.Fragment>
    { [ ...new Array(prediction) ].map(() => <Skeleton />) }
  </React.Fragment>

export default Fallback
