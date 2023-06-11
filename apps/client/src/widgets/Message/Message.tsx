import React from 'react'
import styled from 'styled-components'

interface Props {
  readonly authorName: string
  readonly content: string
  readonly date: string
}

const Message: React.FC<Props> = ({ authorName, content, date }) =>
  <Wrapper>
    <Header>
      <span><b>{ authorName }</b></span>
      <Date>{ date }</Date>
    </Header>
    <p>{ content }</p>
  </Wrapper>

const Wrapper = styled.div(({ theme }) => `
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
