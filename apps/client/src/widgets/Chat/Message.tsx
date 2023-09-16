import React from 'react'
import Avatar from '@mui/material/Avatar'
import Box from '@mui/material/Box'
import Typography from '@mui/material/Typography'
import { styled } from '@mui/material/styles'

interface Props {
  readonly id: string
  readonly content: string
  readonly author: string
  readonly date: string
}

const Message: React.FC<Props> = ({ id, content, author, date }) =>
  <Box component='div'>
    <Container>
      <Avatar>{ author.substring(0, 1).toUpperCase() }</Avatar>
      <Content>
        <Head>
          <Typography variant='subtitle1'>{ author }</Typography>
          <Typography variant='subtitle2'>{ date }</Typography>
        </Head>
        <Typography variant='body1'>{ content }</Typography>
      </Content>
    </Container>
  </Box>

const Container = styled('div')({
  display: 'flex',
  alignItems: 'center',
  gap: 6
})

const Content = styled('div')({
  display: 'flex',
  flexDirection: 'column'
})

const Head = styled('div')({
  display: 'flex',
  gap: 6,
  alignItems: 'center'
})

export default Message
