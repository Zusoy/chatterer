import { Component } from '@angular/core';
import { FormControl } from '@angular/forms';

@Component({
  selector: 'app-stations-create',
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.scss']
})
export class CreateComponent
{
  public readonly name: FormControl;
  public readonly description: FormControl;

  constructor() {
    this.name = new FormControl('');
    this.description = new FormControl('');
  }
}
