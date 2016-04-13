import {Message, MessagePrive} from './Message';

export class Touitos {
	constructor(private id: number, private nom: string, private email: string, private photo: string, private statut: string, public messagesPublic?: Array<Message>, private messagesPrive?: Array<MessagePrive>) {}
} 