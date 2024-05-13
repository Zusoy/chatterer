import { type AppDispatch, type RootState } from 'app/store'
import { CommandConfig, ICommand } from 'features/Console/ICommand'
import { ArrowRightStartOnRectangleIcon } from '@heroicons/react/24/outline'
import { logout } from 'features/Me/Logout/slice'

export default class Logout implements ICommand {
  getConfig(): CommandConfig {
    return ({
      label: 'Logout',
      tag: 'logout',
      description: 'Logout from chatterer',
      icon: <ArrowRightStartOnRectangleIcon strokeWidth={2.5} className={`h-3.5 w-3.5`} />
    })
  }

  process(dispatch: AppDispatch, _state: RootState): void {
    dispatch(logout())
  }
}
