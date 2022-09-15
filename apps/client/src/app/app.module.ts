// Modules Imports
import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';
import { AppRoutingModule } from './app-routing.module';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import nebular from '@modules/nebular.module';
import { StationsModule } from '@modules/stations.module';

// Components Imports
import { AppComponent } from '@components/app.component';
import { MainLayoutComponent } from '@components/Layouts/main-layout.component';
import { HomeComponent } from '@components/Home/home.component';

// Services Imports
import { ApiClient } from '@services/api-client.service';
import { apiServices } from '@services/api';

@NgModule({
  declarations: [
    AppComponent,
    MainLayoutComponent,
    HomeComponent
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    AppRoutingModule,
    FormsModule,
    ReactiveFormsModule,
    StationsModule,
    nebular
  ],
  providers: [
    ApiClient,
    apiServices
  ],
  bootstrap: [AppComponent]
})
export class AppModule
{
}
