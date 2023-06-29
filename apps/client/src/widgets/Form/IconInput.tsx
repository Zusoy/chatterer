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
}

const IconInput: React.FC<Props> = ({
  onChange,
  placeholder,
  required,
  type,
  icon,
  value,
  disabled = false
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

const BaseInput = styled.input<{ disabled: boolean }>(({ theme, disabled }) => `
  background-color: ${ disabled ? theme.colors.dark50 : theme.colors.lightDark };
  height: 37px;
  border-radius: 10px;
  color: ${ theme.colors.white };
  border: none;
  padding: ${ theme.gap.sm } ${ theme.gap.sm } ${ theme.gap.sm } ${ theme.gap.l };
  width: 100%;
`)

export default IconInput
