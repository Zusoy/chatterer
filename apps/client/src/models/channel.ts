import { type Nullable } from 'utils'
import { type StationLite } from 'models/station'

export type Channel = {
  id: string
  name: string
  description: Nullable<string>
  createdAt: string
  updatedAt: string
  station: StationLite
}

export type ChannelLite = {
  id: string
  name: string
}
