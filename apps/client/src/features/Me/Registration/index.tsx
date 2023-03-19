import React, { FormEvent, useState } from 'react';
import Form from 'widgets/Form/Form';
import Input from 'widgets/Form/Input';
import Button from 'widgets/Button/Button';
import styled from 'styled-components';
import registration from 'features/Me/Registration/slice';
import { useDispatch } from 'react-redux';

const Registration: React.FC = () => {
  const [ firstname, setFirstname ] = useState<string>('');
  const [ lastname, setLastname ] = useState<string>('');
  const [ email, setEmail ] = useState<string>('');
  const [ password, setPassword ] = useState<string>('');
  const dispatch = useDispatch();

  const onSubmitHandler: React.EventHandler<FormEvent> = e => {
    e.preventDefault();

    dispatch(registration.actions.register({ firstname, lastname, email, password }));
  }

  return (
    <Wrapper>
      <Form onSubmit={ onSubmitHandler }>
        <FormWrapper>
          <h1>Join your friends!</h1>
          <InputWrapper>
            <Input
              label='Firstname'
              name='firstname'
              type='text'
              required={ true }
              onChange={ e => setFirstname(e.target.value) }
            />
            <Input
              label='Lastname'
              name='lastname'
              type='text'
              required={ true }
              onChange={ e => setLastname(e.target.value) }
            />
          </InputWrapper>
          <InputWrapper>
            <Input
              label='Email'
              name='email'
              type='email'
              required={ true }
              onChange={ e => setEmail(e.target.value) }
            />
            <Input
              label='Password'
              name='password'
              type='password'
              required={ true }
              onChange={ e => setPassword(e.target.value) }
            />
          </InputWrapper>
          <Button type='submit' variant='secondary'>Register</Button>
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
  padding: ${theme.gap.l};
  color: ${theme.colors.white};
`)

const InputWrapper = styled.div(({ theme }) => `
  display: flex;
  gap: ${theme.gap.s};
`)

const FormWrapper = styled.div(({ theme }) => `
  display: flex;
  align-items: center;
  flex-direction: column;
  gap: ${theme.gap.l};
`)

export default Registration;
