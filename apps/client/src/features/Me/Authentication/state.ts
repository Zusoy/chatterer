import { Actions, ActionTypes } from 'features/Me/Authentication/actions';

export enum AuthStatus {
  Anonymous = 'Anonymous',
  Authenticating = 'Authenticating',
  Authenticated = 'Authenticated',
  ReAuthenticating = 'ReAuthenticating',
  UnknownError = 'UnknownError'
}

interface State {
  authStatus: AuthStatus;
}

export const initialState: State = ({
  authStatus: AuthStatus.Anonymous,
})

const reducer = (state = initialState, action: Actions): State => {
  switch (action.type) {
    case ActionTypes.Authenticate:
      return {
        ...state,
        authStatus: AuthStatus.Authenticating,
      };

    case ActionTypes.ReAuthenticate:
      return {
        ...state,
        authStatus: AuthStatus.ReAuthenticating,
      }

    case ActionTypes.NotReAuthenticate:
      return {
        ...state,
        authStatus: AuthStatus.Anonymous,
      }

    case ActionTypes.Authenticated:
      return {
        ...state,
        authStatus: AuthStatus.Authenticated,
      }

    case ActionTypes.Logout:
      return {
        ...state,
        authStatus: AuthStatus.Authenticated,
      }
  }

  return state;
}

export default reducer;
