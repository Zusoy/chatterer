import React from 'react'
import styled from 'styled-components'

interface Props {
  readonly active: boolean
  readonly name: string
  readonly onClick: React.MouseEventHandler
}

const Badge: React.FC<Props> = ({ active, name, onClick }) => {
  return(
    <Wrapper onClick={ onClick } active={ active }>
      <span>{ name }</span>
    </Wrapper>
  )
}

const Wrapper = styled.div<{ active: boolean }>(({ theme, active }) => `
  display: flex;
  color: ${ theme.colors.white };
  cursor: pointer;
  width: 100%;
  height: 50px;
  align-items: center;
  justify-content: center;
  background-color: ${ active ? theme.colors.dark100 : 'transparent' };

  &:hover {
    background-color: ${ theme.colors.dark25 };
  }
`)

export default Badge
