import React from 'react'

type Props = React.PropsWithChildren

const Sidebar: React.FC<Props> = ({ children }) =>
  <aside
    className='
      fixed
      top-0
      left-0
      z-40
      w-64
      h-screen
      transition-transform
      -translate-x-full
      sm:translate-x-0
    '
  >
    <div className="h-full px-3 py-4 overflow-y-auto bg-gray-100">
      <ul className="space-y-2 font-medium">
        {children}
      </ul>
    </div>
  </aside>

export default Sidebar
