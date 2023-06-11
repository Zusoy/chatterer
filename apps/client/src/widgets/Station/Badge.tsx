import React from 'react'
import styled from 'styled-components'

interface Props {
  readonly active: boolean
  readonly name: string
  readonly onClick: React.MouseEventHandler
}

const Badge: React.FC<Props> = ({ active, name, onClick }) =>
  <Wrapper title={ name } onClick={ onClick } active={ active }>
    <span>{ name.substring(0, 1).toUpperCase() }</span>
  </Wrapper>

const Wrapper = styled.div<{ active: boolean }>(({ theme, active }) => `
  display: flex;
  color: ${ theme.colors.white };
  background-color: ${ theme.colors.lightDark };
  border: 1px solid ${ active ? theme.colors.blue : theme.colors.lightDark };
  border-radius: 100px;
  width: 50px;
  height: 50px;
  align-items: center;
  justify-content: center;
  cursor: pointer;

  &:hover {
    border: 1px solid ${ theme.colors.blue };
  }

  ${ active &&
    `&:before {
      content: '';
      position: absolute;
      border-color: ${ theme.colors.white };
      border-top-left-radius: 5px;
      border-bottom-left-radius: 5px;
      background-color: ${ theme.colors.white };
      border-style: solid
      border-width: 0.5rem;
      height: 3em;
      width: 0.5rem;
      left: calc( 0.25rem + 5px );
    }`
  }
`)

export default Badge
