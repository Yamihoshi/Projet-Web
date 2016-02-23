import {MessagesComponent} from './Messages.component';
import {Message, MessagePrive} from './Message';
import {Component, View, Input,Injectable, Directive} from 'angular2/core';
import {AppProfil} from './AppProfil.component';


@Component({
	selector: 'my-profil',
	inputs: ['touitos'],
})

@View({
	templateUrl: './representationTouitos.html',
	directives: [MessagesComponent]
})


export class TouitosComponent{

}