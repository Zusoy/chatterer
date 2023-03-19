import React, { useEffect } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import authentication, { selectIsReAuthenticating } from 'features/Me/Authentication/slice';
import Authentication from 'features/Me/Authentication';
import { selectIsAuth } from 'features/Me/slice';

interface Props {
  children: React.ReactNode;
}

const Firewall: React.FC<Props> = ({ children }) => {
  const isAuth = useSelector(selectIsAuth);
  const isReauthenticating = useSelector(selectIsReAuthenticating);
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(authentication.actions.reAuthenticate());
  }, [ dispatch ]);

  if (isReauthenticating) {
    return <p>Loading...</p>
  }

  if (!isAuth) {
    return <Authentication />
  }

  return (
    <>{ children }</>
  )
}

export default Firewall;
