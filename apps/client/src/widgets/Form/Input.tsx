import React, { ChangeEventHandler, HTMLInputTypeAttribute } from 'react';
import Label from 'widgets/Form/Label';
import Form from 'react-bootstrap/Form';
import styled from 'styled-components';

interface Props {
  name: string;
  required: boolean;
  type: HTMLInputTypeAttribute;
  placeholder?: string;
  value?: string | number | string[] | undefined;
  onChange?: ChangeEventHandler<HTMLInputElement>;
  disabled?: boolean;
  label?: string;
}

const Input: React.FC<Props> = ({
  name,
  onChange,
  required,
  type,
  placeholder,
  value,
  disabled,
  label,
}) =>
  <Form.Group>
    { label &&
      <Label htmlFor={ name }>{ label }</Label>
    }
    <Control
      type={ type }
      id={ name }
      name={ name }
      onChange={ onChange }
      required={ required }
      placeholder={ placeholder }
      value={ value }
      disabled={ disabled }
    />
  </Form.Group>

const Control = styled(Form.Control)(({ theme }) => `
  background-color: ${theme.colors.dark100};
  color: ${theme.colors.white};

  &:focus {
    background-color: ${theme.colors.dark75};
    color: ${theme.colors.white};
  }
`)

export default Input;
