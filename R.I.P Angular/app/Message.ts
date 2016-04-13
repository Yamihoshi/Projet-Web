export class Message {
	constructor(private idMessage: number, private idAuteur: number, private date: Date, private texte: string, private reponse?: Array<Message>) { }
}
export class MessagePrive  {
	constructor(private idDestinaire:number){
	}
}