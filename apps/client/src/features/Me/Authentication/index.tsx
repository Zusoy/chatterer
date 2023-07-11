import React from 'react'
import styled from 'styled-components'
import Form from 'widgets/Form/Form'
import Input from 'widgets/Form/Input'
import PrimaryButton from 'widgets/Button/Primary'
import { authenticate } from 'features/Me/Authentication/slice'
import { useDispatch } from 'react-redux'

const Login: React.FC = () => {
  const dispatch = useDispatch()

  const onSubmitHandler: React.FormEventHandler = e => {
    e.preventDefault()

    const data = new FormData(e.currentTarget as HTMLFormElement)
    const [ username, password ] = [ data.get('username')?.toString() || '', data.get('password')?.toString() || '' ]

    dispatch(authenticate({ username, password }))
  }

  return (
    <Background>
      <Wrapper>
        <h1>Chatterer - Login</h1>
        <Form onSubmit={ onSubmitHandler }>
          <Input
            type='email'
            name='username'
            required={ true }
            placeholder={ 'Email' }
          />
          <Input
            type='password'
            name='password'
            required={ true }
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
