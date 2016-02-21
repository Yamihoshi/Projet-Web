export class Message {
	constructor(private idMessage: number, private idAuteur: number, private date: Date, private texte: string, private reponse?: Message[]) { }
}
export class MessagePrive extends Message {
	destinaire: string;
}