import React from 'react'
import styled from 'styled-components'
import { FaPlus } from 'react-icons/fa'

interface Props {
  readonly onClick: React.MouseEventHandler
}

const JoinBadge: React.FC<Props> = ({ onClick }) =>
  <Wrapper title='Join' onClick={ onClick }>
    <FaPlus size={ 20 } />
  </Wrapper>

const Wrapper = styled.div(({ theme }) => `
  display: flex;
  color: ${ theme.colors.white };
  background-color: ${ theme.colors.lightDark };
  border-radius: 100px;
  width: 50px;
  height: 50px;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: border-radius 0.5s ease-in-out;
  transition: background-color 0.5s ease-in-out;

  &:hover {
    border: 1px solid ${ theme.colors.blue };
    background-color: ${ theme.colors.blue };
    border-radius: 15px;
  }
`)

export default JoinBadge
