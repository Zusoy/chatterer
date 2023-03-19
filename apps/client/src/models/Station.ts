import { ChannelLite } from 'models/Channel';

export interface Station {
  id: string;
  name: string;
  description: string;
  createdAt: string;
  updatedAt: string;
  channels: ChannelLite[];
}

export interface StationLite {
  id: string;
  name: string;
}
