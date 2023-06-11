import { ChannelLite } from 'models/channel'
import { Nullable } from 'utils'

export interface Station {
	id: string
	name: string
	description: Nullable<string>
	createdAt: string
	updatedAt: string
  channels: ChannelLite[]
}

export interface StationLite {
	id: string
	name: string
}
