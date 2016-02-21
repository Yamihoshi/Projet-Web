import {Component, OnInit} from 'angular2/core';
import {Touitos} from './Touitos';
import {TouitosComponent} from './Touitos.component';

//import {Message, MessagePrive} from './Message';
import {TouitosService} from './Touitos.service';
import { RouteConfig, ROUTER_DIRECTIVES, ROUTER_PROVIDERS } from 'angular2/router';

@Component({
	selector: 'touitos',
	directives: [TouitosComponent], 
	template: `<my-current [touitos]="touitos"></my-current>`,
	providers: [TouitosService]
})

export class AppProfil implements OnInit{
	touitos: Touitos;
	constructor(private _touitosService: TouitosService) { }
	getTouitos(){
		this.touitos = this._touitosService.getTouitos();
	}
	ngOnInit(){
		console.log("pd");
		this.getTouitos();
		console.log(this.touitos);
	}
} 

