// Modules Imports
import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';
import { AppRoutingModule } from './app-routing.module';

// Nebular Imports
import { NbThemeModule } from '@nebular/theme';
import { NbSidebarModule } from '@nebular/theme';
import { NbLayoutModule } from '@nebular/theme';
import { NbCardModule } from '@nebular/theme';
import { NbButtonModule } from '@nebular/theme';
import { NbListModule } from '@nebular/theme';
import { NbUserModule } from '@nebular/theme';

// Components Imports
import { AppComponent } from '@components/app.component';
import { MainLayoutComponent } from '@components/Layouts/main-layout.component';
import { HomeComponent } from '@components/Home/home.component';
import StationsListComponent from '@components/Stations/List';

// Services Imports
import { ApiClient } from '@services/api-client.service';
import { apiServices } from '@services/api';

@NgModule({
  declarations: [
    AppComponent,
    MainLayoutComponent,
    HomeComponent,
    StationsListComponent
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    AppRoutingModule,
    NbThemeModule.forRoot({ name: 'cosmic' }),
    NbSidebarModule.forRoot(),
    NbLayoutModule,
    NbCardModule,
    NbButtonModule,
    NbListModule,
    NbUserModule
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
