import React from 'react'
import { FaPowerOff } from 'react-icons/fa'
import { useDispatch } from 'react-redux'
import { logout } from 'features/Me/Logout/slice'
import styled from 'styled-components'

const Logout: React.FC = () => {
  const dispatch = useDispatch()

  const logoutHandler = () => {
    dispatch(logout())
  }

  return (
    <Wrapper title={ 'Logout' }>
      <FaPowerOff onClick={ logoutHandler } size={ 20 } />
    </Wrapper>
  )
}

const Wrapper = styled.span(({ theme }) => `
  color: ${ theme.colors.lightBlue };
  cursor: pointer;
`)

export default Logout
