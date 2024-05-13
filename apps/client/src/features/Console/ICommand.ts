import { type AppDispatch, type RootState } from 'app/store'
import { type ReactNode } from 'react'
import { type Nullable } from 'utils'

export type CommandConfig = {
  label: string
  tag: string
  description: Nullable<string>
  icon: Nullable<ReactNode>
}

export interface ICommand {
  getConfig(): CommandConfig
  process(dispatch: AppDispatch, state: RootState): void
}
