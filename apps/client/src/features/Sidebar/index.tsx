import React, { PropsWithChildren } from 'react'
import MuiDrawer from '@mui/material/Drawer'
import Toolbar from '@mui/material/Toolbar'
import IconButton from '@mui/material/IconButton'
import ChevronLeft from '@mui/icons-material/ChevronLeft'
import Divider from '@mui/material/Divider'
import Menu from 'features/Sidebar/Menu'
import { styled } from '@mui/material/styles'

interface Props extends PropsWithChildren {
  readonly open: boolean
  readonly toggleSidebar: () => void
}

const Drawer = styled(MuiDrawer, { shouldForwardProp: (prop) => prop !== 'open' })(
  ({ theme, open }) => ({
    '& .MuiDrawer-paper': {
      position: 'relative',
      whiteSpace: 'nowrap',
      width: 240,
      transition: theme.transitions.create('width', {
        easing: theme.transitions.easing.sharp,
        duration: theme.transitions.duration.enteringScreen,
      }),
      boxSizing: 'border-box',
      ...(!open && {
        overflowX: 'hidden',
        transition: theme.transitions.create('width', {
          easing: theme.transitions.easing.sharp,
          duration: theme.transitions.duration.leavingScreen,
        }),
        width: theme.spacing(7),
        [theme.breakpoints.up('sm')]: {
          width: theme.spacing(9),
        },
      }),
    },
  }),
)

const Sidebar: React.FC<Props> = ({ open, toggleSidebar, children }) =>
  <Drawer open={ open } variant='permanent'>
    <Toolbar
      sx={{
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'flex-end',
        px: [1]
      }}
    >
      <IconButton onClick={ toggleSidebar }>
        <ChevronLeft />
      </IconButton>
    </Toolbar>
    <Divider />
    { children }
  </Drawer>

export default Sidebar
