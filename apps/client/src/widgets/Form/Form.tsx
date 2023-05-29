import React from 'react'
import styled from 'styled-components'

interface Props {
  readonly children: React.ReactNode
  readonly onSubmit: React.FormEventHandler
}

const Form: React.FC<Props> = ({ children, onSubmit }) =>
  <FormBase onSubmit={ onSubmit}>
    { children }
  </FormBase>

const FormBase = styled.form(({ theme }) => `
  display: flex;
  flex-direction: column;
  gap: ${ theme.gap.m };
  width: 100%;
`)

export default Form
