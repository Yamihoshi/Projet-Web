import {MessagesComponent} from './Messages.component';
import {Message, MessagePrive} from './Message';
import {Component,Input,Injectable} from 'angular2/core';
import {AppProfil} from './AppProfil.component';


@Component({
	selector: 'my-current',
	templateUrl: './representationTouitos.html',
	inputs: ['touitos'],
	directives:[MessagesComponent]
})

export class TouitosComponent{

}