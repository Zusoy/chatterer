import { type User } from 'models/user'
import { type Station } from 'models/station'
import { type Channel } from 'models/channel'
import { type Message } from 'models/message'

export const userMock: User = {
  id: 'ac199cb3-4211-4912-a32b-ab93d3a5bb7d',
  firstname: 'John',
  lastname: 'Doe',
  email: 'john.doe@fake.com',
  isAdmin: false,
  createdAt: '2023-01-01',
  updatedAt: '2023-01-01',
}

export const stationMock: Station = {
  id: 'ac199cb3-4211-4912-a32b-ab9b7d3d3a5b',
  name: 'Company',
  description: 'Just a station',
  createdAt: '2023-01-01',
  updatedAt: '2023-01-01',
}

export const channelMock: Channel = {
  id: 'ac199cb3-4211-4912-a32b-ab93d3a5bb7d',
  name: 'General',
  description: 'just general chat channel',
  createdAt: '2023-01-01',
  updatedAt: '2023-01-01',
  station: {
    id: 'ac199cb3-4211-4912-a32b-ab9b7d3d3a5b',
    name: 'Company'
  }
}

export const messageMock: Message = {
  id: 'ac199cb3-4211-4912-a32b-ab93d3a5bb7d',
  content: 'Hello World !',
  createdAt: '2023-01-01',
  updatedAt: '2023-01-01',
  author: {
    id: 'ac199cb3-4211-4912-a32b-ab9b7d3d3a5b',
    name: 'John Doe'
  },
  channel: {
    id: 'ac199cb3-4211-4912-a32b-ab9b7d3d3a5b',
    name: 'General'
  }
}
