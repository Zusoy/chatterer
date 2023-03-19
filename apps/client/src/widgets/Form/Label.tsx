import React from 'react';
import Form from 'react-bootstrap/Form';

interface Props {
  children: React.ReactNode;
  htmlFor?: string;
}

const Label: React.FC<Props> = ({ children, htmlFor }) =>
  <Form.Label htmlFor={ htmlFor }>{ children }</Form.Label>

export default Label;
