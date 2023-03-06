import React, { useState } from 'react';
import { Form, Grid, Segment, Header, Button, Image } from 'semantic-ui-react';

interface Props {
  isAuthenticating: boolean;
  login: (username: string, password: string) => void;
}

const View: React.FC<Props> = ({ isAuthenticating, login }) => {
  const [ username, setUsername ] = useState<string>('');
  const [ password, setPassword ] = useState<string>('');

  type OnSubmit = (e: React.FormEvent<HTMLFormElement>) => void;
  const onFormSubmit: OnSubmit = e => {
    e.preventDefault();
    login(username, password);
  }

  return (
    <Grid textAlign='center' verticalAlign='middle' style={{ height: '100vh' }}>
      <Grid.Column style={{ maxWidth: 450 }}>
        <Header as='h2' color='black' textAlign='center'>
          <Image src='/logo.png' />Login to your account
        </Header>
        <Form size='large' onSubmit={ onFormSubmit }>
          <Segment stacked>
          <Form.Input
            fluid
            icon='user'
            iconPosition='left'
            placeholder='E-mail address'
            onChange={ e => setUsername(e.target.value) }
          />
          <Form.Input
              fluid
              icon='lock'
              iconPosition='left'
              placeholder='Password'
              type='password'
              onChange={ e => setPassword(e.target.value) }
            />
            <Button type='submit' color='black' fluid size='large' disabled={ isAuthenticating }>
              Login
            </Button>
          </Segment>
        </Form>
      </Grid.Column>
    </Grid>
  )
}

export default View;
