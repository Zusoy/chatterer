import { connect } from 'react-redux';
import { RootState } from 'app/store';
import { AuthStatus } from 'features/Me/Authentication/state';
import { Dispatch } from 'redux';
import * as actions from 'features/Me/Authentication/actions';
import View from 'features/Me/Authentication/View';

const mapStateToProps = (state: RootState) => ({
  isAuthenticating: state.authentication.authStatus === AuthStatus.Authenticating,
})

const mapDispatchToProps = (dispatch: Dispatch) => ({
  login: (username: string, password: string) => dispatch(new actions.AuthenticateAction(username, password)),
})

export default connect(mapStateToProps, mapDispatchToProps)(View);
