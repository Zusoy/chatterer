import React from 'react'
import { createPortal } from 'react-dom'
import styled from 'styled-components'

interface Props {
  readonly children: React.ReactNode
  readonly title: string
}

const Modal: React.FC<Props> = ({ children, title }) =>
  createPortal(
    <Wrapper title={ title }>
      { children }
    </Wrapper>,
    document.querySelector('#modal') as Element
  )

const Wrapper = styled.div(({ theme }) => `
  display: flex;
  padding: ${ theme.gap.sm };
`)

export default Modal
