boann.config(['$stateProvider', '$urlMatcherFactoryProvider', '$urlRouterProvider', '$locationProvider',
    function($stateProvider, $urlMatcherFactoryProvider, $urlRouterProvider, $locationProvider){
        $urlRouterProvider.otherwise("/login/");
        $urlMatcherFactoryProvider.caseInsensitive(true);

        $stateProvider
            .state({
                name:"admin",
                url: "/admin/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/navbar.html?v="+controler.version,
                        //controller: "NavbarController",
                    },

                    "mainpage" : {
                        templateUrl : "./html/admin/home.html?v="+controler.version,
                        controller  : "adminController",
                    },
                }
            })

            .state({
                name:"update",
                url: "/update/:uuid",
                views : {
                    "navbar" : {
                        templateUrl : "./html/navbar.html?v="+controler.version,
                        //controller: "NavbarController",
                    },

                    "mainpage" : {
                        templateUrl : "./html/admin/home.html?v="+controler.version,
                        controller  : "adminController",
                    },
                }
            })

            .state({
                name:"agenda",
                url: "/agenda/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/navbar.html?v="+controler.version,
                        //controller: "NavbarController",
                    },

                    "mainpage" : {
                        templateUrl : "./html/home.html?v="+controler.version,
                        controller  : "HomeController",
                    },
                }
            })

            .state({
                name:"login",
                url: "/login/",
                views : {
                    /*"navbar" : {
                        templateUrl : "./html/navbar.html?v="+controler.version,
                        //controller: "NavbarController",
                    },*/

                    "mainpage" : {
                        templateUrl : "./html/login.html?v="+controler.version,
                        controller  : "loginController",
                    },
                }
            });
}]);