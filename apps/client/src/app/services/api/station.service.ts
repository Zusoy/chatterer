import { Observable } from 'rxjs';
import { Injectable } from '@angular/core';
import { ApiClient } from '@services/api-client.service';
import { Station, StationPayload } from '@models/Station';

@Injectable()
export class StationApi
{
  constructor(private api: ApiClient) {
  }

  get(id: string): Observable<Station> {
    return this.api.get<Station>(`station/${id}`);
  }

  create(payload: StationPayload): Observable<Station> {
    return this.api.post<Station>('stations', payload);
  }

  update(id: string, payload: StationPayload): Observable<Station> {
    return this.api.put<Station>(`station/${id}`, payload);
  }

  list(): Observable<Station[]> {
    return this.api.get<Station[]>('stations');
  }
}
