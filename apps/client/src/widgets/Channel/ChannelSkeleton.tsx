import React from 'react'
import { Typography } from '@material-tailwind/react'

const ChannelSkeleton: React.FC = () =>
  <div className='animate-pulse max-w-full flex items-center justify-center'>
    <Typography
      as="div"
      variant="h1"
      className="mb-4 h-4 w-56 rounded-full bg-gray-300"
      placeholder={undefined}
    >
      &nbsp;
    </Typography>
  </div>

export default ChannelSkeleton
