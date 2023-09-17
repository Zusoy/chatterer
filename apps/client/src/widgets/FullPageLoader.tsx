import React from 'react'
import Box from '@mui/material/Box'
import CircularProgress from '@mui/material/CircularProgress'
import Typography from '@mui/material/Typography'

const FullPageLoader: React.FC = () =>
  <Box
    sx={{
      display: 'flex',
      flexDirection: 'column',
      gap: 4,
      alignItems: 'center',
      justifyContent: 'center',
      minHeight: '100vh'
    }}
  >
    <CircularProgress color='inherit' />
    <Typography variant='body2'>Thanks using Chatterer !</Typography>
  </Box>

export default FullPageLoader
