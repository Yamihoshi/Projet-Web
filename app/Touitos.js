System.register([], function(exports_1) {
    var Touitos;
    return {
        setters:[],
        execute: function() {
            Touitos = (function () {
                function Touitos(id, nom, email, photo, statut, messagesPublic, messagesPrive) {
                    this.id = id;
                    this.nom = nom;
                    this.email = email;
                    this.photo = photo;
                    this.statut = statut;
                    this.messagesPublic = messagesPublic;
                    this.messagesPrive = messagesPrive;
                }
                return Touitos;
            })();
            exports_1("Touitos", Touitos);
        }
    }
});
//# sourceMappingURL=Touitos.js.map