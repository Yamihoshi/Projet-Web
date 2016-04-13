import {Injectable} from 'angular2/core';
import {Message} from './Message';
import {Touitos} from './Touitos';


@Injectable()
export class TouitosService {
	hero: Touitos 
	constructor(){
		this.hero = new Touitos(15, "Loski", "los@g.com", "photo.org", "Occupé", [new Message(4, 1, new Date(1995, 3), "cucul", [new Message(4, 1, new Date(1995, 3), "Bite", null), new Message(4, 1, new Date(1995, 3), "Enfoiré", null)])], null);
	}
	getTouitos(){
		return this.hero;
	}
}


