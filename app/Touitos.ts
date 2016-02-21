import {Message, MessagePrive} from './Message';

export class Touitos {
	constructor(private id: number, private nom: string, private email: string, private photo: string, private statut: string, private messagePublic?: Message[], private MessagePrive?: MessagePrive[]) {}
} 