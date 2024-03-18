import { type Nullable, type Opaque } from 'utils'
import { type StationLite } from 'models/station'

export type ChannelId = Opaque<'ChannelId', string>

export type Channel = {
  id: ChannelId
  name: string
  description: Nullable<string>
  createdAt: string
  updatedAt: string
  station: StationLite
}

export type ChannelLite = {
  id: ChannelId
  name: string
}
