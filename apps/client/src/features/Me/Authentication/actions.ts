import { Action } from 'redux';

export enum ActionTypes {
  Authenticate = 'Me/Authenticate',
  Logout = 'Me/Logout',
  ReAuthenticate = 'Me/ReAuthenticate',
  NotReAuthenticate = 'Me/NotReAuthenticate',
  Authenticated = 'Me/Authenticated',
}

export class AuthenticateAction implements Action {
  readonly type = ActionTypes.Authenticate;
  constructor(public readonly username: string, public readonly password: string) {}
}

export class LogoutAction implements Action {
  readonly type = ActionTypes.Logout;
}

export class ReAuthenticateAction implements Action {
  readonly type = ActionTypes.ReAuthenticate;
}

export class NotReAuthenticateAction implements Action {
  readonly type = ActionTypes.NotReAuthenticate;
}

export class AuthenticatedAction implements Action {
  readonly type = ActionTypes.Authenticated;
  constructor(public readonly id: string) {}
}

export type Actions =
  AuthenticateAction |
  LogoutAction |
  ReAuthenticateAction |
  NotReAuthenticateAction |
  AuthenticatedAction;
