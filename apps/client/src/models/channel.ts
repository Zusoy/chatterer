import { Nullable } from 'utils'
import { IStationLite } from 'models/station'

export interface IChannel {
  id: string
  name: string
  description: Nullable<string>
  createdAt: string
  updatedAt: string
  station: IStationLite
}

export interface IChannelLite {
  id: string
  name: string
}
