"use strict";
boann.controller('adminController', ['$scope', '$http', '$window', '$state', '$stateParams', function($scope, $http, $window, $state, $stateParams) {
         console.log($state.$current.url.pattern.split("/")[1] + " = case name");
         console.log($state.router.globals.$current.views.mainpage.controller + " is Loaded");

         var URI       =   controler.view + "agenda/index.php";  
         var action    =   $state.$current.url.pattern.split("/")[1];


         switch(action){
            case "update" :
               if($stateParams.uuid){                  
                  var VALUES = [{data:$stateParams.uuid}];
                  $http.post(URI, VALUES, {params:{action:"thisAppointment"}}).then(function(data){
                        if(data.status === 200){
                           console.log(data.data)
                           $scope.from = data.data; 

                           $('#datum').find('.fas').addClass('active');                      
                           $('#datum').find('label').addClass('active');

                           $('#time').find('.fas').addClass('active');                      
                           $('#time').find('label').addClass('active');

                           $('#subject').find('.fas').addClass('active');                      
                           $('#subject').find('label').addClass('active'); 
                           
                           $('#locatie').find('.fas').addClass('active');                      
                           $('#locatie').find('label').addClass('active'); 
                        }
                  }); 
               }

               $scope.save = function(data){
                  if(data){
                     var VALUES = [{data:data}];
                     $http.post(URI, VALUES, {params:{action:"updateAppointment"}}).then(function(data){
                        console.log(data.data);
                        switch(data.data.data){
                           case "success":
                              $state.go(data.data.dataUri); 
                           break;

                           case "errors":
                              swal("Oeps!", data.data.dataContent, "error"); 
                           break;
                        }
                     });
                  }else{
                     //error
                     swal("Oeps!", "Alle velden zijn leeg!", "error");
                  }
               }
            break;

            case "nieuwe-afspraak" :
                  $scope.save = function(data){
                     if(data){
                        var VALUES = [{data:data}];
                        $http.post(URI, VALUES, {params:{action:"newAppointment"}}).then(function(data){
                              if(data.status === 200){ 
                                 console.log(data.data);                                    
                                 switch(data.data.data){
                                    case "success":
                                       $state.go(data.data.dataUri); 
                                    break;

                                    case "errors":
                                       swal("Oeps!", data.data.dataContent, "error"); 
                                    break;
                                 }
                              }
                        });                  
                     }else{
                        //error
                        swal("Oeps!", "Alle velden zijn leeg!", "error");
                     };
                  }
            break;
         }


         $http.get(URI, {params:{action:"getClienten"}}).then(function(data){
              if(data.status === 200){
                  if(data.data !== 'null'){
                     $scope.clienten = data.data;                                                                  
                  }
              };
         });

         checkUserLogin();
         function checkUserLogin(){
             $http.get(URI).then(function(data){
                 if(data.status === 200){
                     $state.go(data.data.dataUri);                                               
                 };
             });
         }

         /*https://github.com/mdbootstrap*/
         /*https://github.com/mdbootstrap/mdb-docs-and-content/blob/master/en/jquery/web/docs/latest/javascript/time-picker.html */
         $('#input_starttime').pickatime({
            twelvehour: true, // 12 or 24 hour            
            'default': 'now',
         });

         /*https://github.com/mdbootstrap/mdb-docs-and-content/blob/master/en/jquery/web/docs/latest/javascript/date-picker.html */
         $('.datepicker').pickadate({});

         //https://www.tiny.cloud/tinymce/
         //options for the textearia
         $scope.tinymceOptions = {
            plugins: 'link image code',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | code'
         };
}]);