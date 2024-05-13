import React from 'react'
import { Avatar, Typography, Chip } from '@material-tailwind/react'

type Props = {
  id: string
  authorName: string
  content: string
  createdAt: string
}

const Message: React.FC<Props> = ({ id, authorName, content, createdAt }) =>
  <div className='flex bg-white flex-row min-w-full gap-2 p-4 justify-center hover:bg-blue-gray-50 cursor-pointer' key={id}>
    <div className='flex justify-center'>
      <Avatar
        src='https://docs.material-tailwind.com/img/face-2.jpg'
        alt={authorName}
      />
    </div>
    <div className='flex flex-col w-full justify-center'>
      <div className='flex flex-row gap-4 items-center'>
        <Typography variant='lead'>{authorName}</Typography>
        <Chip
          size='sm'
          value={(new Date(createdAt).toLocaleDateString())}
          variant='ghost'
        />
      </div>
      <Typography variant='paragraph'>{content}</Typography>
    </div>
  </div>

export default Message
