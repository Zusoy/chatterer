import { ChannelLite } from 'models/channel';
import { UserLite } from 'models/user';

export interface Message {
  id: string;
  content: string;
  createdAt: string;
  updatedAt: string;
  channel: ChannelLite;
  author: UserLite;
}
