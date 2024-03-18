import React from 'react'
import { Spinner } from '@material-tailwind/react'

const FullpageLoader: React.FC = () =>
  <div className='flex h-screen items-center justify-center m-auto'>
    <Spinner className="h-16 w-16 text-gray-900/50" />
  </div>

export default FullpageLoader
