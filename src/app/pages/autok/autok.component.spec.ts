import { ComponentFixture, TestBed } from '@angular/core/testing';
import { AutokComponent } from './autok.component';
import { HttpClientTestingModule } from '@angular/common/http/testing';
import { ActivatedRoute } from '@angular/router';
import { RouterTestingModule } from '@angular/router/testing';
import { of } from 'rxjs';

describe('AutokComponent', () => {
  let component: AutokComponent;
  let fixture: ComponentFixture<AutokComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [
        AutokComponent,
        HttpClientTestingModule,
        RouterTestingModule,
      ],
      providers: [
        {
          provide: ActivatedRoute,
          useValue: {
            queryParams: of({}),
            snapshot: { queryParams: {} },
          },
        },
      ],
    }).compileComponents();

    fixture = TestBed.createComponent(AutokComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});