import React from 'react'
import styled from 'styled-components'

interface Props {
  readonly onChange: React.ChangeEventHandler<HTMLInputElement>
  readonly placeholder: string
  readonly required: boolean
  readonly type: React.HTMLInputTypeAttribute
  readonly icon: React.ReactNode
  readonly disabled?: boolean
  readonly value?: string
  readonly color: 'light' | 'dark'
}

const IconInput: React.FC<Props> = ({
  onChange,
  placeholder,
  required,
  type,
  icon,
  value,
  disabled = false,
  color
}) =>
  <Wrapper>
    <IconWrapper>
      { icon }
    </IconWrapper>
    <BaseInput
      type={ type }
      required={ required }
      onChange={ onChange }
      placeholder={ placeholder }
      value={ value }
      disabled={ disabled }
      color={ color }
    />
  </Wrapper>

const Wrapper = styled.div`
  display: flex;
  width: 100%;
  align-items: center;
`

const IconWrapper = styled.div(({ theme }) => `
  position: absolute;
  padding: ${ theme.gap.sm };
`)

const BaseInput = styled.input<{ color: 'light' | 'dark' }>(({ theme, color }) => `
  background-color: ${ color === 'dark' ? theme.colors.lightDark : theme.colors.lightGrey };
  height: 37px;
  border-radius: 10px;
  color: ${ theme.colors.lightDark };
  border: none;
  padding: ${ theme.gap.sm } ${ theme.gap.sm } ${ theme.gap.sm } ${ theme.gap.l };
  width: 100%;
`)

export default IconInput
