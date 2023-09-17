import { IUser } from 'models/user'
import { IStation } from 'models/station'
import { IChannel } from 'models/channel'
import { IMessage } from 'models/message'

export const userMock: IUser = {
  id: 'ac199cb3-4211-4912-a32b-ab93d3a5bb7d',
  firstname: 'John',
  lastname: 'Doe',
  email: 'john.doe@fake.com',
  isAdmin: false,
  createdAt: '2023-01-01',
  updatedAt: '2023-01-01',
}

export const stationMock: IStation = {
  id: 'c3e014f3-dc32-4b2b-afd9-ab597da74046',
  name: 'Company',
  description: null,
  createdAt: '2023-01-01',
  updatedAt: '2023-01-01',
  channels: []
}

export const channelMock: IChannel = {
  id: '283a6bd2-ddd1-45f5-9e79-b79f8ef6f3a9',
  name: 'General',
  description: 'General discussions',
  createdAt: '2023-01-01',
  updatedAt: '2023-01-01',
  station: stationMock
}

export const messageMock: IMessage = {
  id: '15b5c108-8372-4a13-9de1-8841b9cdf196',
  content: 'Hello world !',
  createdAt: '2023-01-01',
  updatedAt: '2023-01-01',
  author: {
    id: 'ad53d256-a27e-4212-89a0-a7732e10b904',
    name: 'John Doe',
  },
  channel: channelMock
}
