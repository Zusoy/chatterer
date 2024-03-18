import React from 'react'
import Skeleton from 'widgets/Message/MessageSkeleton'

type Props = {
  prediction: number
}

const Fallback: React.FC<Props> = ({ prediction }) =>
  <React.Fragment>
    { [...new Array(prediction)].map((_val, i) => <Skeleton key={i} />) }
  </React.Fragment>

export default Fallback
