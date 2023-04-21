"use strict";
boann.controller('loginController', ['$scope', '$http', '$window', '$state', function($scope, $http, $window, $state) {
        var URI       =   controler.view + "login/index.php";  

        checkUserLogin();

        function checkUserLogin(){
            $http.get(URI).then(function(data){
                if(data.status === 200){
                    $state.go(data.data.dataUri);                                               
                };
            });
        }

        $scope.loginUser = function(data){
            if(data){
                    $scope.error = "";
                    var VALUES = [{data:data}];
                    $http.post(URI, VALUES, {params:{action:"login"}}).then(function(data){
                        if(data.status === 200){
                            console.log(data.data);                        
                            switch(data.data.data){
                               case "success" :
                                    $scope.success = data.data.dataContent;
                                    $state.go(data.data.dataUri);  
                               break;

                               case "error" :                        
                                    swal("Oeps!", data.data.dataContent, "error");
                               break;
                            }
                        };
                    });
            }else{
                        swal("Oeps!", "Alle velden zijn verplicht!", "error");                               
            }
        }

}]);