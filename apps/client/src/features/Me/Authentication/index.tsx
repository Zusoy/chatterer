import React, { useState } from 'react'
import styled from 'styled-components'
import Form from 'widgets/Form/Form'
import Input from 'widgets/Form/Input'
import PrimaryButton from 'widgets/Button/Primary'
import { authenticate } from 'features/Me/Authentication/slice'
import { useDispatch } from 'react-redux'

const Login: React.FC = () => {
  const [ username, setUsername ] = useState('')
  const [ password, setPassword ] = useState('')
  const dispatch = useDispatch()

  const onSubmitHandler: React.FormEventHandler = e => {
    e.preventDefault()

    dispatch(authenticate({ username, password }))
  }

  return (
    <Background>
      <Wrapper>
        <h1>Chatterer - Login</h1>
        <Form onSubmit={ onSubmitHandler }>
          <Input
            type='email'
            required={ true }
            onChange={ e => setUsername(e.target.value) }
            placeholder={ 'Email' }
          />
          <Input
            type='password'
            required={ true }
            onChange={ e => setPassword(e.target.value) }
            placeholder={ 'Password' }
          />
          <PrimaryButton type='submit'>Login</PrimaryButton>
        </Form>
      </Wrapper>
    </Background>
  )
}

const Wrapper = styled.div(({ theme }) => `
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 500px;
  height: 300px;
  background-color: ${ theme.colors.dark25 };
  border-radius: 10px;
  gap: ${ theme.gap.sm };
  margin: auto;
  padding: ${ theme.gap.m };
  color: ${ theme.colors.white };
`)

const Background = styled.div(({ theme }) => `
  display: flex;
  min-height: 100vh;
  background-color: ${ theme.colors.dark75 };
`)

export default Login
