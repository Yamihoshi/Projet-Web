System.register([], function(exports_1) {
    var Touitos;
    return {
        setters:[],
        execute: function() {
            Touitos = (function () {
                function Touitos(id, nom, email, photo, statut, messagePublic, MessagePrive) {
                    this.id = id;
                    this.nom = nom;
                    this.email = email;
                    this.photo = photo;
                    this.statut = statut;
                    this.messagePublic = messagePublic;
                    this.MessagePrive = MessagePrive;
                }
                return Touitos;
            })();
            exports_1("Touitos", Touitos);
        }
    }
});
//# sourceMappingURL=Touitos.js.map