import { all, fork } from 'redux-saga/effects'
import authentication from 'features/Me/Authentication/effects'

const effects = function* (): Generator {
  yield all([
    fork(authentication),
  ])
}

export default effects
