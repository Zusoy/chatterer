import React, { useState } from 'react'
import Modal from 'widgets/Modal'
import Form from 'widgets/Form/Form'
import Input from 'widgets/Form/Input'
import PrimaryButton from 'widgets/Button/Primary'
import SecondaryButton from 'widgets/Button/Secondary'
import styled from 'styled-components'

interface Props {
  onCancel: React.MouseEventHandler
}

const Join: React.FC<Props> = ({ onCancel }) => {
  const [ token, setToken ] = useState<string>('')

  const onSubmitHandler: React.FormEventHandler = e => {
    e.preventDefault()

    console.log(token)
  }

  return (
    <Modal title={ 'Join new station' }>
      <Wrapper>
        <Header>
          <h2>Join a station</h2>
          <p>Type your station invitation token here to join an existing station</p>
        </Header>
        <Form onSubmit={ onSubmitHandler }>
          <Input
            required={ true }
            placeholder='Invitation token'
            onChange={ e => setToken(e.target.value) }
            value={ token }
            type='text'
          />
          <Buttons>
            <SecondaryButton onClick={ onCancel }>Cancel</SecondaryButton>
            <PrimaryButton type='submit'>Join the station</PrimaryButton>
          </Buttons>
        </Form>
      </Wrapper>
    </Modal>
  )
}

const Wrapper = styled.div(({ theme }) => `
  display: flex;
  flex-direction: column;
  gap: ${ theme.gap.sm };
  justify-content: center;
  align-items: center;
  padding: ${ theme.gap.m };
`)

const Header = styled.header`
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
`

const Buttons = styled.div(({ theme }) => `
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: ${ theme.gap.s };
`)

export default Join
