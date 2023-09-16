import React from 'react'
import ListItemButton from '@mui/material/ListItemButton'
import ListItemAvatar from '@mui/material/ListItemAvatar'
import ListItemText from '@mui/material/ListItemText'
import Avatar from '@mui/material/Avatar'

interface Props {
  readonly name: string
  readonly onClick: () => void
  readonly selected: boolean
}

const Item: React.FC<Props> = ({ name, onClick, selected }) =>
  <ListItemButton onClick={ () => onClick() } selected={ selected }>
    <ListItemAvatar>
      <Avatar alt={ name }>{ name.substring(0, 1).toUpperCase() }</Avatar>
    </ListItemAvatar>
    <ListItemText primary={ name } />
  </ListItemButton>

export default Item
