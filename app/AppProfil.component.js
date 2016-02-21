System.register(['angular2/core', './Touitos.component', './Touitos.service'], function(exports_1) {
    var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
        var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
        if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
        else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
        return c > 3 && r && Object.defineProperty(target, key, r), r;
    };
    var __metadata = (this && this.__metadata) || function (k, v) {
        if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
    };
    var core_1, Touitos_component_1, Touitos_service_1;
    var AppProfil;
    return {
        setters:[
            function (core_1_1) {
                core_1 = core_1_1;
            },
            function (Touitos_component_1_1) {
                Touitos_component_1 = Touitos_component_1_1;
            },
            function (Touitos_service_1_1) {
                Touitos_service_1 = Touitos_service_1_1;
            }],
        execute: function() {
            AppProfil = (function () {
                function AppProfil(_touitosService) {
                    this._touitosService = _touitosService;
                }
                AppProfil.prototype.getTouitos = function () {
                    this.touitos = this._touitosService.getTouitos();
                };
                AppProfil.prototype.ngOnInit = function () {
                    console.log("pd");
                    this.getTouitos();
                    console.log(this.touitos);
                };
                AppProfil = __decorate([
                    core_1.Component({
                        selector: 'touitos',
                        directives: [Touitos_component_1.TouitosComponent],
                        template: "<my-current [touitos]=\"touitos\"></my-current>",
                        providers: [Touitos_service_1.TouitosService]
                    }), 
                    __metadata('design:paramtypes', [Touitos_service_1.TouitosService])
                ], AppProfil);
                return AppProfil;
            })();
            exports_1("AppProfil", AppProfil);
        }
    }
});
//# sourceMappingURL=AppProfil.component.js.map