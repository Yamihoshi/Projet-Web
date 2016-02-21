System.register(['./Messages.component', 'angular2/core'], function(exports_1) {
    var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
        var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
        if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
        else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
        return c > 3 && r && Object.defineProperty(target, key, r), r;
    };
    var __metadata = (this && this.__metadata) || function (k, v) {
        if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
    };
    var Messages_component_1, core_1;
    var TouitosComponent;
    return {
        setters:[
            function (Messages_component_1_1) {
                Messages_component_1 = Messages_component_1_1;
            },
            function (core_1_1) {
                core_1 = core_1_1;
            }],
        execute: function() {
            TouitosComponent = (function () {
                function TouitosComponent() {
                }
                TouitosComponent = __decorate([
                    core_1.Component({
                        selector: 'my-current',
                        templateUrl: './representationTouitos.html',
                        inputs: ['touitos'],
                        directives: [Messages_component_1.MessagesComponent]
                    }), 
                    __metadata('design:paramtypes', [])
                ], TouitosComponent);
                return TouitosComponent;
            })();
            exports_1("TouitosComponent", TouitosComponent);
        }
    }
});
//# sourceMappingURL=Touitos.component.js.map