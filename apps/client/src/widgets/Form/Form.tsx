import React from 'react';
import { default as BtForm } from 'react-bootstrap/Form';

interface Props {
  children: React.ReactNode;
  onSubmit: React.FormEventHandler;
}

const Form: React.FC<Props> = ({ children, onSubmit }) =>
  <BtForm onSubmit={ onSubmit }>
    { children }
  </BtForm>

export default Form;
