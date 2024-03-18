import React from 'react'
import Skeleton from 'widgets/Channel/ChannelSkeleton'
import { ListItem } from '@material-tailwind/react'

type Props = {
  prediction: number
}

const Fallback: React.FC<Props> = ({ prediction }) =>
  <React.Fragment>
    { [...new Array(prediction)].map((_val, i) => <ListItem key={i} placeholder='loading'><Skeleton /></ListItem>) }
  </React.Fragment>

export default Fallback
