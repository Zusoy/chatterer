import { Component, OnDestroy, OnInit } from '@angular/core';
import { Station } from '@models/Station';
import { StationApi } from '@services/api/station.service';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-stations-list',
  templateUrl: './stations-list.component.html'
})
export class StationsListComponent implements OnInit, OnDestroy
{
  public stations: Station[];
  private subscriptions: Subscription;

  constructor(
    private stationsClient: StationApi
  ) {
    this.stations = [];
    this.subscriptions = new Subscription();
  }

  ngOnInit(): void {
    this.subscriptions.add(
      this.stationsClient.list().subscribe(
        stations => {
          this.stations = stations;
        }
      )
    );
  }

  ngOnDestroy(): void {
    this.subscriptions.unsubscribe();
  }
}
