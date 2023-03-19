import React from 'react';
import { Button as BtButton } from 'react-bootstrap';
import { ButtonVariant } from 'react-bootstrap/esm/types';

interface Props {
  variant: ButtonVariant;
  children: React.ReactNode;
  type: 'submit' | 'button';
  onClick?: React.MouseEventHandler;
}

const Button: React.FC<Props> = ({ variant, children, onClick, type }) =>
  <BtButton
    variant={ variant }
    onClick={ onClick }
    type={ type }
  >
    { children }
  </BtButton>

export default Button;
