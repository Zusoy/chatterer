import { Component, OnDestroy, OnInit, TemplateRef } from '@angular/core';
import { Station } from '@models/Station';
import { NbDialogService } from '@nebular/theme';
import { StationApi } from '@services/api/station.service';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-stations-list',
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.scss']
})
export class ListComponent implements OnInit, OnDestroy
{
  public stations: Station[];
  private subscriptions: Subscription;

  constructor(
    private stationsClient: StationApi,
    private dialogs: NbDialogService
  ) {
    this.stations = [];
    this.subscriptions = new Subscription();
  }

  openNewDialog(newDialog: TemplateRef<any>): void {
    this.dialogs.open(newDialog, { hasBackdrop: true });
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
