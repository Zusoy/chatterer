import { StationLite } from 'models/station';

export interface Channel {
  id: string;
  name: string;
  description: string;
  createdAt: string;
  updatedAt: string;
  station: StationLite;
}

export type ChannelLite = Omit<Channel, 'description'|'createdAt'|'updatedAt'|'station'>
