import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { reAuthenticate, selectIsReAuthenticating } from 'features/Me/Authentication/slice'
import { selectIsAuth } from 'features/Me/slice'
import Loader from 'widgets/FullpageLoader'
import LoginForm from 'features/Me/Authentication'

type Props = React.PropsWithChildren

const Firewall: React.FC<Props> = ({ children }) => {
  const isAuth = useSelector(selectIsAuth)
  const isReAuth = useSelector(selectIsReAuthenticating)
  const dispatch = useDispatch()

  useEffect(() => {
    dispatch(reAuthenticate())
  }, [dispatch])

  if (isReAuth) {
    return <Loader />
  }

  if (!isAuth) {
    return <LoginForm />
  }

  return (
    <React.Fragment>
      {children}
    </React.Fragment>
  )
}

export default Firewall
