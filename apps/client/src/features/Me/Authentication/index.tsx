import React, { useState, FormEvent } from 'react';
import Form from 'widgets/Form/Form';
import Input from 'widgets/Form/Input';
import Button from 'widgets/Button/Button';
import styled from 'styled-components';
import { useDispatch } from 'react-redux';
import authentication, { AuthenticatePayload } from 'features/Me/Authentication/slice';

const Authentication: React.FC = () => {
  const [ username, setUsername ] = useState<string>('');
  const [ password, setPassword ] = useState<string>('');
  const dispatch = useDispatch();

  const onSubmitHandler: React.EventHandler<FormEvent> = e => {
    e.preventDefault();

    const payload: AuthenticatePayload = {
      username,
      password
    };

    dispatch(authentication.actions.authenticate(payload));
  }

  return (
    <Wrapper>
      <Form onSubmit={ onSubmitHandler }>
        <FormWrapper>
          <h1>Welcome back!</h1>
          <Input
            label='Username'
            name='username'
            type='email'
            required={ true }
            onChange={ e => setUsername(e.target.value) }
          />
          <Input
            label='Password'
            name='password'
            type='password'
            required={ true }
            onChange={ e => setPassword(e.target.value) }
          />
          <Button type='submit' variant='secondary'>Login</Button>
        </FormWrapper>
      </Form>
    </Wrapper>
  )
}

const Wrapper = styled.div(({ theme }) => `
  position:absolute;
  left:50%;
  top:50%;
  transform:translate(-50%, -50%);
  border: solid 1px;
  border-radius: 2%;
  background-color: ${theme.colors.dark50};
  padding: ${theme.gap.xl};
  color: ${theme.colors.white};
`)

const FormWrapper = styled.div(({ theme }) => `
  display: flex;
  align-items: center;
  flex-direction: column;
  gap: ${theme.gap.sm};
`)

export default Authentication;
