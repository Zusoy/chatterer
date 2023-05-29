import React, { useEffect } from 'react'
import authentication, { selectIsReAuthenticating } from 'features/Me/Authentication/slice'
import Login from 'features/Me/Authentication'
import { useDispatch, useSelector } from 'react-redux'
import { selectIsAuth } from 'features/Me/slice'

interface Props {
  readonly children: React.ReactNode
}

const Firewall: React.FC<Props> = ({ children }) => {
  const isAuth = useSelector(selectIsAuth)
  const isReAuthenticating = useSelector(selectIsReAuthenticating)
  const dispatch = useDispatch()

  useEffect(() => {
    dispatch(authentication.actions.reAuthenticate())
  }, [ dispatch ])

  if (isReAuthenticating) {
    return <p>Loading your informations...</p>
  }

  if (!isAuth) {
    return <Login />
  }

  return <>{ children }</>
}

export default Firewall
