import { StationLite } from 'models/Station';

export interface Channel {
  id: string;
  name: string;
  description: string;
  createdAt: string;
  updatedAt: string;
  station: StationLite;
}

export interface ChannelLite {
  id: string;
  name: string;
}
