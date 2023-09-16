import React from 'react'
import ListItemButton from '@mui/material/ListItemButton'
import ListItemAvatar from '@mui/material/ListItemAvatar'
import Avatar from '@mui/material/Avatar'
import ListItemText from '@mui/material/ListItemText'
import AddBox from '@mui/icons-material/AddBox'

interface Props {
  readonly onClick: () => void
}

const AddStation: React.FC<Props> = ({ onClick }) =>
  <ListItemButton onClick={ () => onClick() }>
    <ListItemAvatar>
      <Avatar>
        <AddBox color='inherit' />
      </Avatar>
    </ListItemAvatar>
    <ListItemText primary='Add station' />
  </ListItemButton>

export default AddStation
