import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import CreateStation from '@components/Stations/Create';
import ListStation from '@components/Stations/List';
import nebular from '@modules/nebular.module';

@NgModule({
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    nebular
  ],
  declarations: [
    CreateStation,
    ListStation
  ],
  exports: [
    CreateStation,
    ListStation
  ]
})
export class StationsModule
{
}
