"use strict";
boann.controller('reportsController', ['$scope', '$http', '$window', '$state', '$stateParams', function($scope, $http, $window, $state, $stateParams) {
         console.log($state.$current.url.pattern.split("/")[1] + " = case name");
         console.log($state.router.globals.$current.views.mainpage.controller + " is Loaded");

         var URI       =   controler.view + "reports/index.php";  
         var action    =   $state.$current.url.pattern.split("/")[1];


         switch(action){
            case "dagen" :
               $http.get(URI, {params:{action:"days"}}).then(function(data){
                  if(data.status === 200){
                        if(data.data !== 'null'){ 
                           $scope.days = data.data; 
                        }
                  };
               });  

               $scope.trashModel = function(data){
                  $('#basicExampleModal').modal('show');
                  $scope.trash = data;
               }

               $scope.trashDay = function(data){
                  if(data){


                     /*var VALUES = [{data:data}];
                     $http.post(URI, VALUES, {params:{action:"removeDays"}}).then(function(data){
                        console.log(data.data);
                     });*/
                  }
               }
            break;   
            
            case "reports" :
               $http.get(URI, {params:{action:"getReports"}}).then(function(data){
                  if(data.status == 200){
                     $scope.reports = data.data;                    
                  }
               });


               $scope.readReport = function(data){
                  if(data){
                     $scope.modal = data;                     
                     $('#basicExampleModal').modal('show');
                  }
               }

               $scope.trashReport = function(data){
                  if(data){
                     var VALUES = [{data:data}];
                     $http.post(URI, VALUES, {params:{action:"removeReport"}}).then(function(data){
                        console.log(data.data);
                     });
                  }
               }
            break;

            case "new-report" :
               $scope.save  = function(data){
                  if(data){
                     var VALUES = [{data:data}];
                     $http.post(URI, VALUES, {params:{action:"newReport"}}).then(function(data){
                           console.log(data.data);
                           switch(data.data.data){
                                case "success":
                                    $state.go('reports');                              
                                break;

                                case "error":
                                    swal("Oeps!", data.data.dataContent, "error");                             
                                break;
                            }   
                     })
                  }else{
                     swal("Oeps!", "Alle velden zijn verplicht!", "error"); 
                  }
               }
            break;
         }


         

         //https://www.tiny.cloud/tinymce/
         //options for the textearia
         $scope.tinymceOptions = {
            height: 600,
            plugins: 'link image code',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | code'
         };
}]);