import {Component, View, Input, Inject} from 'angular2/core';
import {Message} from './Message';

@Component({
	selector: 'message',
	inputs: ['messages']
})

@View({
	templateUrl: "messages.html",
	directives: [MessagesComponent]
})

export class MessagesComponent{
	@Inject(Message)  messages: Array<Message>;
}