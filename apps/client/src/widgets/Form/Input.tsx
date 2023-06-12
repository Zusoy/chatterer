import React from 'react'
import styled from 'styled-components'

interface Props {
  readonly onChange: React.ChangeEventHandler<HTMLInputElement>
  readonly placeholder: string
  readonly required: boolean
  readonly type: React.HTMLInputTypeAttribute
  readonly value?: string
}

const Input: React.FC<Props> = ({ onChange, placeholder, required, type, value }) =>
  <Wrapper>
    <BaseInput
      type={ type }
      required={ required }
      onChange={ onChange }
      placeholder={ placeholder }
      value={ value }
    />
  </Wrapper>

const Wrapper = styled.div(({ theme }) => `
  display: flex;
  flex-direction: column;
  gap: ${ theme.gap.sm };
`)

const BaseInput = styled.input(({ theme }) => `
  background-color: ${ theme.colors.dark50 };
  height: 37px;
  border-radius: 10px;
  color: ${ theme.colors.white };
  border: none;
  padding: ${ theme.gap.sm };
`)

export default Input
