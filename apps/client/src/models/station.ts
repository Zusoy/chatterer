import { Nullable } from 'utils'
import { IChannelLite } from 'models/channel'

export interface IStation {
  id: string
  name: string
  description: Nullable<string>
  createdAt: string
  updatedAt: string
  channels: IChannelLite[]
}

export interface IStationLite {
  id: string
  name: string
}
