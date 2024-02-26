import { type Nullable } from 'utils'

export type Station = {
  id: string
  name: string
  description: Nullable<string>,
  createdAt: string
  updatedAt: string
}

export type StationLite = {
  id: string
  name: string
}
