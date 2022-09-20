import { Action } from '@ngrx/store';

export enum ActionTypes {
  LoadStations = 'stations/load_stations',
  LoadStationsSuccess = 'stations/load_stations_success',
  LoadStationsFailure = 'stations/load_stations_failure'
}

export class LoadStationsAction implements Action
{
  readonly type: string = ActionTypes.LoadStations;
}

export class LoadStationsSuccessAction implements Action
{
  readonly type: string = ActionTypes.LoadStationsSuccess;
}

export class LoadStationsFailureAction implements Action
{
  readonly type: string = ActionTypes.LoadStationsFailure;
}

export type Actions =
  LoadStationsAction |
  LoadStationsSuccessAction |
  LoadStationsFailureAction;
