import React from 'react'
import Box from '@mui/material/Box'
import Container from '@mui/material/Container'
import Button from '@mui/material/Button'
import TextField from '@mui/material/TextField'
import { useDispatch } from 'react-redux'
import { authenticate } from 'features/Me/Authentication/slice'

const Authentication: React.FC = () => {
  const dispatch = useDispatch()

  const onSubmitHandler: React.FormEventHandler = e => {
    e.preventDefault()

    const data = new FormData(e.currentTarget as HTMLFormElement)
    const [ username, password ] = [ data.get('username')?.toString() || '', data.get('password')?.toString() || '' ]

    dispatch(authenticate({ username, password }))
  }

  return (
    <Container
      component="main"
      maxWidth="xs"
      sx={
        {
          display: 'flex',
          flexDirection: 'column',
          minHeight: '100vh',
          alignItems: 'center',
          justifyContent: 'center'
        }
      }
    >
      <h1>Chatterer</h1>
      <Box component="form" onSubmit={ onSubmitHandler }>
        <TextField
          required
          fullWidth
          autoFocus
          name="username"
          label="Username"
          type="email"
          margin="normal"
          variant="filled"
        />
        <TextField
          required
          fullWidth
          name="password"
          label="Password"
          type="password"
          margin="normal"
          variant="filled"
        />
        <Button fullWidth type="submit" variant="contained" color="success">Login</Button>
      </Box>
    </Container>
  )
}

export default Authentication
