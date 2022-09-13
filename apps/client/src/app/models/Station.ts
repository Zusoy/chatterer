import { Identifiable } from '@models/Identifiable';

export interface Station extends Identifiable
{
  name: string;
  description: string;
  createdAt: Date;
  updatedAt: Date;
}

export type StationPayload = Omit<Station, 'id'|'createdAt'|'updatedAt'>;
