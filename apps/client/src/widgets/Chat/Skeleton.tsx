import React from 'react'
import Box from '@mui/material/Box'
import MuiSkeleton from '@mui/material/Skeleton'
import { styled } from '@mui/material/styles'

const Skeleton: React.FC = () =>
  <Box>
    <Container>
      <MuiSkeleton animation='wave' variant='circular' width={ 40 } height={ 40 } />
      <Content>
        <Head>
          <MuiSkeleton animation='wave' height={ 10 } width={ 100 } />
        </Head>
        <MuiSkeleton animation='wave' height={ 20 } width={ 200 } />
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

export default Skeleton
