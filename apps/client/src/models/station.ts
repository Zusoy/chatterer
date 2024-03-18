import { type Nullable, type Opaque } from 'utils'

export type StationId = Opaque<'StationId', string>

export type Station = {
  id: StationId
  name: string
  description: Nullable<string>,
  createdAt: string
  updatedAt: string
}

export type StationLite = {
  id: StationId
  name: string
}
