import {Injectable} from 'angular2/core';
import {Message} from './Message';
import {Touitos} from './Touitos';


@Injectable()
export class TouitosService {
	hero: Touitos 
	constructor(){
		this.hero = new Touitos(15, "Loski", "los@g.com", "photo.org", "Occupé", [new Message(4, 1, new Date(1995, 3), "cucul", null)], null);
	}
	getTouitos(){
		console.log(new Message(4, 1, new Date(1995, 3), "cucul", null));
		return this.hero;
	}
}

//