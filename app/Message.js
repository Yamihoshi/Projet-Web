System.register([], function(exports_1) {
    var __extends = (this && this.__extends) || function (d, b) {
        for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
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
            MessagePrive = (function (_super) {
                __extends(MessagePrive, _super);
                function MessagePrive() {
                    _super.apply(this, arguments);
                }
                return MessagePrive;
            })(Message);
            exports_1("MessagePrive", MessagePrive);
        }
    }
});
//# sourceMappingURL=Message.js.map