import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AutokReszletekComponent } from './autok-reszletek.component';

describe('AutokReszletekComponent', () => {
  let component: AutokReszletekComponent;
  let fixture: ComponentFixture<AutokReszletekComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AutokReszletekComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AutokReszletekComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
