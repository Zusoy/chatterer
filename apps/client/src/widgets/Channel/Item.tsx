import React from 'react'
import ListItemButton from '@mui/material/ListItemButton'
import ListItemIcon from '@mui/material/ListItemIcon'
import ListItemText from '@mui/material/ListItemText'
import Tag from '@mui/icons-material/Tag'

interface Props {
  readonly name: string
  readonly onClick: () => void
  readonly selected: boolean
}

const Item: React.FC<Props> = ({ name, onClick, selected }) =>
  <ListItemButton onClick={ () => onClick() } selected={ selected }>
    <ListItemIcon>
      <Tag />
    </ListItemIcon>
    <ListItemText primary={ name } />
  </ListItemButton>

export default Item
