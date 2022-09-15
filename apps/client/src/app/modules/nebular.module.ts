import { NbThemeModule } from '@nebular/theme';
import { NbSidebarModule } from '@nebular/theme';
import { NbDialogModule } from '@nebular/theme';
import { NbLayoutModule } from '@nebular/theme';
import { NbCardModule } from '@nebular/theme';
import { NbButtonModule } from '@nebular/theme';
import { NbListModule } from '@nebular/theme';
import { NbUserModule } from '@nebular/theme';
import { NbInputModule } from '@nebular/theme';

export default [
  NbThemeModule.forRoot({ name: 'cosmic' }),
  NbSidebarModule.forRoot(),
  NbDialogModule.forRoot(),
  NbLayoutModule,
  NbCardModule,
  NbButtonModule,
  NbListModule,
  NbUserModule,
  NbInputModule
];
