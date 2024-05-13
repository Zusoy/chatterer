import React from 'react'
import { Spinner } from '@material-tailwind/react'
import Typography from 'widgets/Texts/Typography'

const FullpageLoader: React.FC = () =>
  <div className='flex flex-col gap-8 h-screen items-center justify-center m-auto'>
    <Spinner className="h-16 w-16 text-gray-900/50" />
    <p className="text-gray-500 dark:text-gray-400 flex flex-col gap-1 items-center">
      <Typography variant='lead'>Did you know ?</Typography>
      <div>
        You can open the Chatterer console by pressing <kbd className="px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">Ctrl</kbd> + <kbd className="px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">Shift</kbd> + <kbd className="px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">P</kbd>
      </div>
    </p>
  </div>

export default FullpageLoader
