import React, { PropsWithChildren, useEffect } from 'react'
import { selectIsReAuthenticating, reAuthenticate } from 'features/Me/Authentication/slice'
import { useDispatch, useSelector } from 'react-redux'
import { selectIsAuth } from 'features/Me/slice'
import Login from 'features/Me/Authentication'

const Firewall: React.FC<PropsWithChildren> = ({ children }) => {
  const isAuth = useSelector(selectIsAuth)
  const isReAuthenticating = useSelector(selectIsReAuthenticating)
  const dispatch = useDispatch()

  useEffect(() => {
    dispatch(reAuthenticate())
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
