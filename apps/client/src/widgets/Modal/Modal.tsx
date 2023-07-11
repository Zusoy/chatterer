import React from 'react'
import { createPortal } from 'react-dom'
import { motion } from 'framer-motion'
import animation from 'widgets/Modal/animation'
import styled from 'styled-components'

interface Props {
  readonly children: React.ReactNode
  readonly title: string
}

const Modal: React.FC<Props> = ({ children, title }) =>
  createPortal(
    <Wrapper title={ title } variants={ animation } initial='hidden' animate='visible'>
      { children }
    </Wrapper>,
    document.querySelector('#modal') as Element
  )

const Wrapper = styled(motion.div)(({ theme }) => `
  display: flex;
`)

export default Modal
