import React from 'react'
import { Typography } from '@material-tailwind/react'

const MessageSkeleton: React.FC = () =>
  <div className='flex flex-row min-w-full gap-2 p-4 justify-center bg-blue-gray-50 animate-pulse'>
    <div className='flex justify-center'>
      <Typography as='div' className='rounded-full bg-gray-300 w-8 h-8'>
        &nbsp;
      </Typography>
    </div>
    <div className='flex flex-col w-full justify-center'>
      <Typography
        as='div'
        variant='lead'
        className='mb-2 h-2 w-72 rounded-full bg-gray-300'
      >
        &nbsp;
      </Typography>
      <Typography
        as='div'
        variant='paragraph'
        className='mb-2 h-2 w-72 rounded-full bg-gray-300'
      >
        &nbsp;
      </Typography>
    </div>
  </div>

export default MessageSkeleton
