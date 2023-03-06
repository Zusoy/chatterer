import { ChannelLite } from 'models/channel';

export interface Station {
  id: string;
  name: string;
  description: string;
  createdAt: string;
  updatedAt: string;
  channels: ChannelLite[];
}

export type StationLite = Omit<Station, 'description'|'createdAt'|'updatedAt'>
