import { createSlice, PayloadAction } from '@reduxjs/toolkit';
import { User } from 'models/User';

export enum RegistrationStatus {
  Initial = 'Initial',
  Registering = 'Registering',
  Registered = 'Registered',
  UnknownError = 'UnknownError'
}

export interface RegistrationPayload {
  email: string;
  firstname: string;
  lastname: string;
  password: string;
}

interface State {
  status: RegistrationStatus;
}

const initialState: State = {
  status: RegistrationStatus.Initial,
}

const slice = createSlice({
  name: 'register',
  initialState,
  reducers: {
    register: (state, _action: PayloadAction<RegistrationPayload>) => ({
      ...state,
      status: RegistrationStatus.Registering,
    }),
    registered: (state, _action: PayloadAction<User>) => ({
      ...state,
      status: RegistrationStatus.Registered,
    }),
    error: state => ({
      ...state,
      status: RegistrationStatus.UnknownError,
    }),
  },
});

export default slice;
