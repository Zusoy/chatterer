import { Station } from 'models/station'
import { Channel } from 'models/channel'

export const stationMock: Station = {
  id: 'c3e014f3-dc32-4b2b-afd9-ab597da74046',
  name: 'Company',
  description: null,
  createdAt: '2023-01-01',
  updatedAt: '2023-01-01',
  channels: []
}

export const channelMock: Channel = {
  id: '283a6bd2-ddd1-45f5-9e79-b79f8ef6f3a9',
  name: 'General',
  description: 'General discussions',
  createdAt: '2023-01-01',
  updatedAt: '2023-01-01',
  station: stationMock
}
