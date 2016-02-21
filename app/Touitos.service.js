System.register(['angular2/core', './Message', './Touitos'], function(exports_1) {
    var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
        var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
        if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
        else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
        return c > 3 && r && Object.defineProperty(target, key, r), r;
    };
    var __metadata = (this && this.__metadata) || function (k, v) {
        if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
    };
    var core_1, Message_1, Touitos_1;
    var TouitosService;
    return {
        setters:[
            function (core_1_1) {
                core_1 = core_1_1;
            },
            function (Message_1_1) {
                Message_1 = Message_1_1;
            },
            function (Touitos_1_1) {
                Touitos_1 = Touitos_1_1;
            }],
        execute: function() {
            TouitosService = (function () {
                function TouitosService() {
                    this.hero = new Touitos_1.Touitos(15, "Loski", "los@g.com", "photo.org", "Occupé", [new Message_1.Message(4, 1, new Date(1995, 3), "cucul", null)], null);
                }
                TouitosService.prototype.getTouitos = function () {
                    console.log(new Message_1.Message(4, 1, new Date(1995, 3), "cucul", null));
                    return this.hero;
                };
                TouitosService = __decorate([
                    core_1.Injectable(), 
                    __metadata('design:paramtypes', [])
                ], TouitosService);
                return TouitosService;
            })();
            exports_1("TouitosService", TouitosService);
        }
    }
});
// 
//# sourceMappingURL=Touitos.service.js.map