import { StationLite } from 'models/station'
import { Nullable } from 'utils'

export interface Channel {
  id: string
  name: string
  description: Nullable<string>
  createdAt: string
  updatedAt: string
  station: StationLite
}

export interface ChannelLite {
  id: string
  name: string
}
