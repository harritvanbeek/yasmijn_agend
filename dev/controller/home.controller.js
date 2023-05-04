"use strict";
boann.controller('HomeController', ['$scope', '$http', '$window', '$state', function($scope, $http, $window, $state) {
        console.log($state.$current.url.pattern.split("/")[1] + " = case name");
        console.log($state.router.globals.$current.views.mainpage.controller + " is Loaded");
        
        var URI         = controler.view + "agenda/index.php"; 
        var action      = $state.$current.url.pattern.split("/")[1];
        $scope.thisTab  = "1";

        switch(action){
            case "clienten" :
                $scope.edit =  function(data){
                    $scope.form = data;                    
                }

                $scope.trash =  function(data){
                    if(data){
                        var VALUES = [{data:data}];
                        $http.post(URI, VALUES, {params:{action:"trashClient"}}).then(function(data){
                            console.log(data.data);
                            switch(data.data.data){
                                case "success":
                                    $state.reload();                              
                                break;

                                case "error":
                                    swal("Oeps!", data.data.dataContent, "error");                             
                                break;
                            }   
                        });
                    }
                }

                $http.get(URI, {params:{action:"getClienten"}}).then(function(data){
                    if(data.status === 200){
                        if(data.data !== 'null'){
                            $scope.clienten = data.data;                                                                  
                        }
                    };
                });

                $scope.save = function(data){
                    if(data){
                        var VALUES = [{data:data}];
                        $http.post(URI, VALUES, {params:{action:"postClienten"}}).then(function(data){
                            console.log(data.data); 
                            switch(data.data.data){
                                case "success":
                                    $state.reload();                              
                                break;

                                case "error":
                                    swal("Oeps!", data.data.dataContent, "error");                             
                                break;
                            }                                  
                        });
                    }
                }             
            break;

            case "changePassword" :
                $scope.updatePassword = function(item){
                    if(item){
                        var VALUES = [{data:item}];
                        $http.post(URI, VALUES, {params:{action:"changePassword"}}).then(function(data){
                                switch(data.data.data){
                                   case "success":
                                      swal({
                                        title   : "Well done!",
                                        text    : data.data.dataContent,
                                        button  : "OK",
                                        closeOnClickOutside: false,
                                        closeOnEsc: false,
                                        icon: "success",
                                      }).then(function(input){
                                            //log user out
                                            location.href = "index.php?action=logout";
                                      });

                                      //swal("Well done!", data.data.dataContent, "success");                           
                                   break;

                                   case "error":
                                      swal("Oeps!", data.data.dataContent, "error");                              
                                   break;
                                }
                        });
                    }else{
                        swal("Oeps!", "Alle velden zijn verplicht!", "error"); 
                    };
                }
            break;

            case "agenda" :
                $http.get(URI, {params:{action:"getAppointments"}}).then(function(data){
                    if(data.status === 200){
                        if(data.data !== 'null'){
                            $scope.agenda = data.data;                                                                  
                        }
                    };
                });

                $scope.edit = function(data){
                    $state.go('update', {uuid:data.appointment.agendaUuid})
                }

                $scope.trash = function(data){
                    if(data){
                        var VALUES = [{data:data.appointment.agendaUuid}];
                        $http.post(URI, VALUES, {params:{action:"deleteAppointment"}}).then(function(data){
                             if(data.status === 200){
                                //console.log(data.data)
                                switch(data.data.data){
                                   case "success":
                                      $state.reload();                              
                                   break;
                                }
                             }
                       }); 
                    }
                }

                $scope.setTable = function(index, item){
                    if(item){
                        var VALUES = [{data:item}];
                        $http.post(URI, VALUES, {params:{action:"getAppointment"}}).then(function(data){
                            if(data.status === 200){
                                $scope.appointment = data.data;
                                $scope.getTable = true;
                                //console.log(data.data);
                            }
                        });                
                    }
                }

                $scope.setTab = function(index){                    
                    $scope.thisTab = index;                   
                } 

                $scope.getTab = function(index){
                    if($scope.thisTab === index){
                        return true;
                    }
                }  
            break;
        } 
        
        

        var tagContainer      = document.querySelector('.tag-container');
        var input             = document.querySelector('.inputTag');

        function createTage(label){
            var div = document.createElement('div');
            div.setAttribute('class', 'tag');
            var span = document.createElement('span');
            span.innerHTML = label;
            var closeBtn = document.createElement('i');
            closeBtn.setAttribute('class', 'far fa-window-close');

            div.appendChild(span);
            div.appendChild(closeBtn);

            return div;
        }

        checkUserLogin();

        function checkUserLogin(){
            $http.get(URI).then(function(data){
                if(data.status === 200){
                    $state.go(data.data.dataUri);                                               
                };
            });
        }
}]);