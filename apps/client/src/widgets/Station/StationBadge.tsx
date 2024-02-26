import React, { useMemo } from 'react'
import { Tooltip } from '@material-tailwind/react'

type Props = {
  name: string
  active: boolean
  onClick: React.MouseEventHandler
}

const StationBadge: React.FC<Props> = ({ name, active, onClick }) => {
  const namePreview = useMemo<string>(() => {
    return name[0]
  }, [name])

  return (
    <Tooltip content={name} placement='right'>
      <div
        className={`flex border-4 border-slate-600 w-16 h-16 justify-center items-center cursor-pointer rounded-xl mt-1 hover:border-gray-900 ${active ? 'bg-gray-900 text-white' : 'bg-white'}`}
        title={name}
        onClick={onClick}
      >
        <span>{namePreview}</span>
      </div>
    </Tooltip>
  )
}

export default StationBadge
