import { type User, type UserId } from 'models/user'
import { type Station, type StationId } from 'models/station'
import { type Channel, type ChannelId } from 'models/channel'
import { type Message, type MessageId } from 'models/message'

export const userMock: User = {
  id: 'ac199cb3-4211-4912-a32b-ab93d3a5bb7d' as UserId,
  firstname: 'John',
  lastname: 'Doe',
  email: 'john.doe@fake.com',
  isAdmin: false,
  createdAt: '2023-01-01',
  updatedAt: '2023-01-01',
}

export const stationMock: Station = {
  id: 'ac199cb3-4211-4912-a32b-ab9b7d3d3a5b' as StationId,
  name: 'Company',
  description: 'Just a station',
  createdAt: '2023-01-01',
  updatedAt: '2023-01-01',
}

export const channelMock: Channel = {
  id: 'ac199cb3-4211-4912-a32b-ab93d3a5bb7d' as ChannelId,
  name: 'General',
  description: 'just general chat channel',
  createdAt: '2023-01-01',
  updatedAt: '2023-01-01',
  station: {
    id: 'ac199cb3-4211-4912-a32b-ab9b7d3d3a5b' as StationId,
    name: 'Company'
  }
}

export const messageMock: Message = {
  id: 'ac199cb3-4211-4912-a32b-ab93d3a5bb7d' as MessageId,
  content: 'Hello World !',
  createdAt: '2023-01-01',
  updatedAt: '2023-01-01',
  author: {
    id: 'ac199cb3-4211-4912-a32b-ab9b7d3d3a5b' as UserId,
    name: 'John Doe'
  },
  channel: {
    id: 'ac199cb3-4211-4912-a32b-ab9b7d3d3a5b' as ChannelId,
    name: 'General'
  }
}
