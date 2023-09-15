import React, { PropsWithChildren } from 'react'
import MuiAppBar from '@mui/material/AppBar'
import IconButton from '@mui/material/IconButton'
import MenuIcon from '@mui/icons-material/Menu'
import Typography from '@mui/material/Typography'
import Toolbar from '@mui/material/Toolbar'
import { styled } from '@mui/material/styles'

interface Props extends PropsWithChildren {
  readonly open: boolean
  readonly toggleSidebar: () => void
}

const AppBar = styled(MuiAppBar, {
  shouldForwardProp: (prop) => prop !== 'open',
})<Props>(({ theme, open }) => ({
  zIndex: theme.zIndex.drawer + 1,
  transition: theme.transitions.create(['width', 'margin'], {
    easing: theme.transitions.easing.sharp,
    duration: theme.transitions.duration.leavingScreen,
  }),
  ...(open && {
    marginLeft: 240,
    width: `calc(100% - 240px)`,
    transition: theme.transitions.create(['width', 'margin'], {
      easing: theme.transitions.easing.sharp,
      duration: theme.transitions.duration.enteringScreen,
    }),
  }),
}));

const Header: React.FC<Props> = ({ open, toggleSidebar, children }) =>
  <AppBar position='absolute' open={ open } toggleSidebar={ toggleSidebar }>
    <Toolbar sx={{ pr: 24 }}>
      <IconButton
        edge='start'
        color='inherit'
        aria-label="open sidebar"
        sx={{
          marginRight: '36px',
          ...(open && { display: 'none' }),
        }}
        onClick={ toggleSidebar }
      >
        <MenuIcon />
      </IconButton>
      <Typography
        component='h1'
        variant='h6'
        color='inherit'
        noWrap
        sx={{ flexGrow: 1 }}
      >
        Chatterer
      </Typography>
      { children }
    </Toolbar>
  </AppBar>

export default Header
