"use strict";
boann.controller('HomeController', ['$scope', '$http', '$window', '$state', function($scope, $http, $window, $state) {
        var URI         =   controler.view + "agenda/index.php";  
        
        $http.get(URI, {params:{action:"getAppointments"}}).then(function(data){
            if(data.status === 200){
                if(data.data !== 'null'){
                    $scope.agenda = data.data;
                    //console.log(data.data);                                               
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
                        console.log(data.data);
                    }
                });                
            }
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