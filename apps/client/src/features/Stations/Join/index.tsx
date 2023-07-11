import React, { useState } from 'react'
import Modal from 'widgets/Modal/Modal'
import Form from 'widgets/Form/Form'
import IconInput from 'widgets/Form/IconInput'
import PrimaryButton from 'widgets/Button/Primary'
import SecondaryButton from 'widgets/Button/Secondary'
import styled from 'styled-components'
import { FaEnvelope } from 'react-icons/fa'
import { join } from 'features/Stations/Join/slice'
import { useDispatch } from 'react-redux'

interface Props {
  readonly onCancel: React.MouseEventHandler
}

const Join: React.FC<Props> = ({ onCancel }) => {
  const dispatch = useDispatch()
  const [ token, setToken ] = useState<string>('')

  const onSubmitHandler: React.FormEventHandler = e => {
    e.preventDefault()

    dispatch(join({ token }))
  }

  return (
    <Modal title={ 'Join new station' }>
      <Wrapper>
        <Header>
          <h2>Join a station</h2>
          <p>Type your station invitation token here to join an existing station</p>
        </Header>
        <Form onSubmit={ onSubmitHandler }>
            <IconInput
              color='light'
              required={ true }
              placeholder='Invitation token'
              onChange={ e => setToken(e.target.value) }
              value={ token }
              icon={ <FaEnvelope size={ 20 } /> }
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
  padding: ${ theme.gap.l };
  background-color: ${ theme.colors.white };
  color: ${ theme.colors.dark75 };
  border-radius: 10px;
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
