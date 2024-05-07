import React from 'react'
import { Tooltip } from '@material-tailwind/react'

type Props = {
  onClick: React.MouseEventHandler<HTMLElement>
}

const NewStationBadge: React.FC<Props> = ({ onClick }) =>
  <Tooltip content='Add a station' placement='right'>
    <div
      className={`flex border-4 border-slate-600 w-16 h-16 justify-center items-center cursor-pointer rounded-xl mt-1 bg-white hover:border-gray-900 '}`}
      onClick={onClick}
    >
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" className="w-6 h-6">
        <path strokeLinecap="round" strokeLinejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
      </svg>
    </div>
  </Tooltip>

export default NewStationBadge
