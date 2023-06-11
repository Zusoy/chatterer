import React from 'react'
import styled from 'styled-components'

interface Props {
  readonly children: React.ReactNode
  readonly onClick?: React.MouseEventHandler
  readonly type: 'submit' | 'button'
}

const Primary: React.FC<Props> = ({ onClick, type, children }) =>
  <Button
    type={ type }
    onClick={ onClick }
  >
    { children }
  </Button>

const Button = styled.button(({ theme }) => `
  align-items: center;
  cursor: pointer;
  display: flex;
  justify-content: center;
  background-color: ${ theme.colors.blue };
  padding: ${ theme.gap.sm } ${ theme.gap.m };
  color: ${ theme.colors.white };
  border: 1px solid ${ theme.colors.blue };
  border-radius: 5px;
`)

export default Primary
