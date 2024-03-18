import { type Opaque } from 'utils'
import { type ChannelLite } from 'models/channel'
import { type UserLite } from 'models/user'

export type MessageId = Opaque<'MessageId', string>

export type Message = {
  id: MessageId
  content: string
  createdAt: string
  updatedAt: string
  channel: ChannelLite
  author: UserLite
}
