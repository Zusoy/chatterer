import React from 'react'
import styled from 'styled-components'
import { motion } from 'framer-motion'

interface Props {
  readonly authorName: string
  readonly content: string
  readonly date: string
}

const Message: React.FC<Props> = ({ authorName, content, date }) =>
  <Wrapper initial={ { x: -200 } } animate={ { x:0 } }>
    <Header>
      <span><b>{ authorName }</b></span>
      <Date>{ date }</Date>
    </Header>
    <p>{ content }</p>
  </Wrapper>

const Wrapper = styled(motion.div)(({ theme }) => `
  display: flex;
  flex-direction: column;
  color: ${ theme.colors.white };
  gap: ${ theme.gap.s };
  width: 100%;
  padding: ${ theme.gap.s };

  &:hover {
    background-color: ${ theme.colors.dark50 };
  }
`)

const Header = styled.div(({ theme }) => `
  display: flex;
  gap: ${ theme.gap.s };
`)

const Date = styled.span(({ theme }) => `
  color: ${ theme.colors.grey };
`)

export default Message
