var admin = angular.module('admin',['ui.router','ngGrid'])
    .config(
        function($provide,$stateProvider,$urlRouterProvider,$httpProvider){
        $urlRouterProvider.otherwise('dashboard');
        $stateProvider
            .state('dashboard',{
                url:'/dashboard',
                templateUrl:'/views/admin/admin-dashboard.html'
            }).state('users',{
                url:'/users',
                templateUrl:'/views/admin/admin-users.html',
                controller:'UsersController',
                resolve:{
                    UsersPromise:function($http)
                    {
                        return $http.get('/admin/users')
                    }
                }
            }).state('applicants',{
                url:'/applicants',
                templateUrl:'/views/admin/admin-applicants.html',
                controller:'ApplicantsController',
                resolve:{
                    ApplicantsPromise:function($http)
                    {
                        return $http.get('/admin/applicant')
                    }
                }
            });
});

admin.run(function($rootScope){
    $rootScope.$on('$stateChangeStart',function(event, toState, toParams, fromState, fromParams){
        $rootScope.showLoader = true;
    });

    $rootScope.$on('$viewContentLoaded',function(){
        $rootScope.showLoader = false;
    });
    $rootScope.$on('$viewContentLoading',function(){
        console.log("view content loading");
        $rootScope.showLoader = true;
    });
})
admin.directive('viewLoader',function(){
    return{
        restrict:'E',
        templateUrl:'/views/admin/view-loader.html',
        link:function(scope,element,attrib,controller){
            console.log("View loader directive's link function called");
        }
    }
});

admin.factory('UserService',function($http){
    return{
        getUserLike:function(name)
        {
            return $http.get('/admin/users/like',{
                params:{
                    name:name
                }
            })
        },
        deleteUser:function(id)
        {
            return $http.delete('/admin/users/'+id,{})
        },
        getUsers:function()
        {
            return $http.get('/admin/users',{})
        }
    }
})

admin.controller("ApplicantsController",function($scope,ApplicantsPromise){
    $scope.applicants = ApplicantsPromise.data;
});

//user controller...loads of todos in here
admin.controller("UsersController",function($rootScope,$scope,UsersPromise,UserService){
    //initialize control bar controls
    $scope.enableAddUser = true
    $scope.enableDeleteUser = "disabled";
    var btnDeleteUser = angular.element("#deleteMenuItem");
    btnDeleteUser.find(".icon-remove").addClass('disabled');

    $scope.hideElement = "hide-element";
    $scope.selectedUser=[];
    $scope.users = UsersPromise.data;
    $scope.gridOptions={
        data:'users',
        multiSelect:false,
        selectedItems:$scope.selectedUser
    };
    $scope.totalUsers=$scope.users.length;
    $scope.filterUsers=function($event){
        $scope.hideElement = "";
        UserService.getUserLike($event.target.value)
            .success(function(result){
                $scope.users=result;
                $scope.hideElement = "hide-element";
            });
    };

    $rootScope.userTypeList = [
        {id:1,value:"Admin"},
        {id:2,value:"Applicant"}
    ]

    $scope.$watchCollection('selectedUser',function(newVal,oldVal){
        if(newVal.length === 0)
        {
            console.log("nothing changed");
            btnDeleteUser.find(".icon-remove").addClass('disabled');
        }
        else
        {
            //console.log(newVal);
            btnDeleteUser.find(".icon-remove").removeClass('disabled');
        }
        $rootScope.enableDeleteUser = true;
        $rootScope.selectedUser = newVal[0];
    });

    $rootScope.deleteUser=function(id)
    {
        console.log($scope.selectedUser[0].id);
        UserService.deleteUser($rootScope.selectedUser.id)
            .success(function(data){
                UserService.getUsers()
                    .success(function(data){
                        $scope.users = data
                    });
            }).error(function(data){
                console.log(data)
            });
    }

    $scope.showMoreOptions=function(){

        var searchBox = angular.element("#search-box-container");
        var moreOptionBtn = searchBox.find("#moreOptions")
        if(moreOptionBtn.text() === "More Options"){
            moreOptionBtn.text("Less Options")
            searchBox.css("height","270px");
            searchBox.find(".more-search-controls").css("opacity",1)
        }
        else
        {
            moreOptionBtn.text("More Options")
            searchBox.css("height","74px");
            searchBox.find(".more-search-controls").css("opacity",0)
        }

    };

});