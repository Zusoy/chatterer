import { IChannelLite } from 'models/channel'
import { IUserLite } from 'models/user'

export interface IMessage {
  id: string
  content: string
  createdAt: string
  updatedAt: string
  channel: IChannelLite
  author: IUserLite
}
