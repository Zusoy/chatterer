import { Action } from '@ngrx/store';

export enum ActionTypes {
  CreateStation = 'stations/create',
  CreateStationSuccess = 'stations/create_success',
  CreateStationFailure = 'stations/create_failure'
}

export class CreateStationAction implements Action
{
  readonly type: string = ActionTypes.CreateStation;
}

export class CreateStationSuccessAction implements Action
{
  readonly type: string = ActionTypes.CreateStationSuccess;
}

export class CreateStationFailureAction implements Action
{
  readonly type: string = ActionTypes.CreateStationFailure;
}

export type Actions =
  CreateStationAction |
  CreateStationSuccessAction |
  CreateStationFailureAction;
