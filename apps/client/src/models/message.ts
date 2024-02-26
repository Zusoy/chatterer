import { type ChannelLite } from 'models/channel'
import { type UserLite } from 'models/user'

export type Message = {
  id: string
  content: string
  createdAt: string
  updatedAt: string
  channel: ChannelLite
  author: UserLite
}
