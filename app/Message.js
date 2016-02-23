System.register([], function(exports_1) {
    var Message, MessagePrive;
    return {
        setters:[],
        execute: function() {
            Message = (function () {
                function Message(idMessage, idAuteur, date, texte, reponse) {
                    this.idMessage = idMessage;
                    this.idAuteur = idAuteur;
                    this.date = date;
                    this.texte = texte;
                    this.reponse = reponse;
                }
                return Message;
            })();
            exports_1("Message", Message);
            MessagePrive = (function () {
                function MessagePrive(idDestinaire) {
                    this.idDestinaire = idDestinaire;
                }
                return MessagePrive;
            })();
            exports_1("MessagePrive", MessagePrive);
        }
    }
});
//# sourceMappingURL=Message.js.map