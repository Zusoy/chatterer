import React from 'react'
import styled from 'styled-components'

interface Props {
  readonly name: string
  readonly onClick: React.MouseEventHandler
}

const Badge: React.FC<Props> = ({ name, onClick }) => {
  return(
    <Wrapper onClick={ onClick }>
      <span>{ name }</span>
    </Wrapper>
  )
}

const Wrapper = styled.div(({ theme }) => `
  display: flex;
  color: ${ theme.colors.white };
  cursor: pointer;
  width: 100%;
  height: 50px;
  align-items: center;
  justify-content: center;

  &:hover {
    background-color: ${ theme.colors.dark25 };
  }
`)

export default Badge
