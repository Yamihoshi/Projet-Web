import {RouteConfig, ROUTER_DIRECTIVES, ROUTER_PROVIDERS } from 'angular2/router';
import {AppProfil} from './AppProfil.component';
import {Component, OnInit} from 'angular2/core';


@Component({
  selector: 'my-app',
  template: `
    <h1>{{title}}</h1>
    <a [routerLink]="['Membre']">Membres</a>
  <router-outlet></router-outlet>`,
  directives: [AppProfil, ROUTER_DIRECTIVES],
  providers: [ROUTER_PROVIDERS]
})

@RouteConfig([
  {
    path: '/',
    name: 'Membre',
    component: AppProfil
  }
])
export class AppComponent {
  title = 'Touiteur LOL';
}
