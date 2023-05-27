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
                name:"changePassword",
                url: "/change-password/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/navbar.html?v="+controler.version,                        
                    },

                    "mainpage" : {
                        templateUrl : "./html/changePassword.html?v="+controler.version,
                        controller  : "HomeController",
                    },
                }
            })

            .state({
                name:"changeUsername",
                url: "/change-username/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/navbar.html?v="+controler.version,                        
                    },

                    "mainpage" : {
                        templateUrl : "./html/changeUsername.html?v="+controler.version,
                        controller  : "HomeController",
                    },
                }
            })

            .state({
                name:"users",
                url: "/clienten/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/navbar.html?v="+controler.version,                        
                    },

                    "mainpage" : {
                        templateUrl : "./html/clienten.html?v="+controler.version,
                        controller  : "HomeController",
                    },
                }
            })

            .state({
                name:"reports",
                url: "/reports/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/navbar.html?v="+controler.version,                        
                    },

                    "mainpage" : {
                        templateUrl : "./html/admin/reports.html?v="+controler.version,
                        controller  : "reportsController",
                    },
                }
            })

            .state({
                name:"new_report",
                url: "/new-report/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/navbar.html?v="+controler.version,                        
                    },

                    "mainpage" : {
                        templateUrl : "./html/admin/new_report.html?v="+controler.version,
                        controller  : "reportsController",
                    },
                }
            })

            .state({
                name:"days",
                url: "/dagen/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/navbar.html?v="+controler.version,                        
                    },

                    "mainpage" : {
                        templateUrl : "./html/admin/dagen.html?v="+controler.version,
                        controller  : "reportsController",
                    },
                }
            })

            .state({
                name:"weeks",
                url: "/weken/",
                views : {
                    "navbar" : {
                        templateUrl : "./html/navbar.html?v="+controler.version,                        
                    },

                    "mainpage" : {
                        templateUrl : "./html/admin/weken.html?v="+controler.version,
                        controller  : "reportsController",
                    },
                }
            })

            .state({
                name:"login",
                url: "/login/",
                views : {
                    "mainpage" : {
                        templateUrl : "./html/login.html?v="+controler.version,
                        controller  : "loginController",
                    },
                }
            });
}]);
