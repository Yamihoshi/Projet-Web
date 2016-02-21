System.register(['angular2/platform/browser', './AppComponent'], function(exports_1) {
    var browser_1, AppComponent_1;
    return {
        setters:[
            function (browser_1_1) {
                browser_1 = browser_1_1;
            },
            function (AppComponent_1_1) {
                AppComponent_1 = AppComponent_1_1;
            }],
        execute: function() {
            browser_1.bootstrap(AppComponent_1.AppComponent);
        }
    }
});
//# sourceMappingURL=main.js.map