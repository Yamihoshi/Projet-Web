import {Component, View, OnInit, Directive} from 'angular2/core';
import {Touitos} from './Touitos';
import {TouitosComponent} from './Touitos.component';
import {TouitosService} from './Touitos.service';
import {RouteConfig, ROUTER_DIRECTIVES, ROUTER_PROVIDERS } from 'angular2/router';

@Component({
	selector: 'touitos',
	providers: [TouitosService]
})

@View({
	template: `<my-profil [touitos]="touitos"></my-profil>`,
	directives: [TouitosComponent]
})

export class AppProfil implements OnInit{
	touitos: Touitos;
	constructor(private _touitosService: TouitosService) { }
	getTouitos(){
		this.touitos = this._touitosService.getTouitos();
	}
	ngOnInit(){
		this.getTouitos();
	}
} 

