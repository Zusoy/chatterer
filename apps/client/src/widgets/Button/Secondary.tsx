import React from 'react'
import styled from 'styled-components'

interface Props {
  readonly children: React.ReactNode
  readonly onClick?: React.MouseEventHandler
}

const Secondary: React.FC<Props> = ({ onClick, children }) =>
  <Button
    type='button'
    onClick={ onClick }
  >
  { children }
  </Button>

const Button = styled.button(({ theme }) => `
  align-items: center;
  cursor: pointer;
  display: flex;
  justify-content: center;
  background-color: ${ theme.colors.white };
  padding: ${ theme.gap.sm } ${ theme.gap.m };
  color: ${ theme.colors.lightDark };
  border: 1px solid ${ theme.colors.white };
  border-radius: 5px;
`)

export default Secondary
