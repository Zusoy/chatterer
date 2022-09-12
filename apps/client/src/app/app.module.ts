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

// Components Imports
import { AppComponent } from '@components/app.component';

// Services Imports
import { ApiClient } from '@services/api-client.service';
import { apiServices } from '@services/api';

@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    AppRoutingModule,
    NbThemeModule.forRoot({ name: 'cosmic' }),
    NbSidebarModule.forRoot(),
    NbLayoutModule,
    NbCardModule,
    NbButtonModule
  ],
  providers: [
    ApiClient,
    apiServices
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
