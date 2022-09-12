import { Component } from '@angular/core';
import { StationApi } from '@services/api/station.service';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-root',
  template: `
  <nb-layout>
    <nb-layout-header fixed>Chatterer</nb-layout-header>
    <nb-sidebar>Sidebar Content</nb-sidebar>
    <nb-layout-column>
    <nb-card status="success">
      <nb-card-header>Nebula</nb-card-header>
      <nb-card-body>
        A nebula is an interstellar cloud of dust, hydrogen, helium and other ionized gases.
        Originally, nebula was a name for any diffuse astronomical object,
        including galaxies beyond the Milky Way.
      </nb-card-body>
      <nb-card-footer>By Wikipedia</nb-card-footer>
    </nb-card>
    <nb-card status="danger">
  <nb-card-header>Nebula</nb-card-header>
    <nb-card-body>
      A nebula is an interstellar cloud of dust, hydrogen, helium and other ionized gases.
      Originally, nebula was a name for any diffuse astronomical object,
      including galaxies beyond the Milky Way.
    </nb-card-body>
    <nb-card-footer>By Wikipedia</nb-card-footer>
  </nb-card>
    </nb-layout-column>
  </nb-layout>
  `
})
export class AppComponent {
  private subscriptions: Subscription;

  constructor(
    private stations: StationApi
  ) {
    this.subscriptions = new Subscription();

    this.subscriptions.add(
      this.stations.list().subscribe(
        stations => {
          console.log(stations)
        }
      )
    );
  }
}
