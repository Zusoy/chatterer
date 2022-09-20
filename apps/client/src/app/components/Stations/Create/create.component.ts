import { Component, EventEmitter, Output } from '@angular/core';
import { FormBuilder, FormControl, FormGroup } from '@angular/forms';

@Component({
  selector: 'app-stations-create',
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.scss']
})
export class CreateComponent
{
  public readonly form: FormGroup;

  @Output()
  public readonly cancel: EventEmitter<void> = new EventEmitter();

  constructor(
    private forms: FormBuilder
  ) {
    this.form = this.forms.group({
      name: new FormControl(''),
      description: new FormControl('')
    });
  }

  public createStation(): void {
    const name = this.form.get('name')?.value;
    const description = this.form.get('description')?.value;

    console.log(name);
    console.log(description);
  }

  public cancelCreation(): void {
    this.cancel.emit();
  }
}
