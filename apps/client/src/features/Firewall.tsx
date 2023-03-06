import React from 'react';
import { RootState } from 'app/store';
import Authentication from 'features/Me/Authentication';
import { connect } from 'react-redux';

type Props = {
  children: React.ReactNode;
  isAuth: boolean;
}

const View: React.FC<Props> = ({ children, isAuth }) => {
  if (!isAuth) {
    return <Authentication />
  }

  return <>{ children }</>
}

const mapStateToProps = (state: RootState) => ({
  isAuth: state.me.id !== null,
})

const Firewall = connect(mapStateToProps)(View)

export default Firewall
