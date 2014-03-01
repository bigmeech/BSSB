var admin = angular.module('admin',['ui.router','ui.grid'])
    .config(
        function($provide,$stateProvider,$urlRouterProvider,$httpProvider){
        $urlRouterProvider.otherwise('dashboard');
        $stateProvider
            .state('dashboard',{
                url:'/dashboard',
                templateUrl:'/views/admin/admin-dashboard.html',
                controller:'DashboardController',
                resolve:{
                    DashBoardDataPromise:function($http){
                        return $http.get('/admin/overview');
                    }
                }
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
                        return $http.get('/admin/applicant');
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

admin.factory('OverviewService',function($http){
    return{
        getSystemStats:function(){
            return $http.get('/admin/overview',{});
        },
        getRecentActivities:function(){

        }
    }
});
admin.factory('ApplicantService',function($http){
    return{
        getApplicants:function(){
            return $http.get('admin/applicant',{});
        },
        findApplicants:function(id){
            return $http.get('admin/applicant/like');
        },
        getApplicantDetails:function(id){
            return $http.get('/admin/applicant/'+id);
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
        },
        searchUser:function(application_id,user_type,email,lastname,firstname){
            return $http.get('/admin/users/more',{
                params:{
                    applicant_id:application_id,
                    user_type:user_type,
                    email:email,
                    lastname:lastname,
                    firstname:firstname
                }
            })
        },
        createUser:function(
            firstname,
            lastname,
            userType,
            emailaddress,
            password){
            return $http.post('/admin/users',{
                firstname:firstname,
                lastname:lastname,
                userType:userType,
                emailaddress:emailaddress,
                password:password
            })
        }
    }
})

admin.controller("ApplicantsController",function($rootScope,$scope,ApplicantsPromise,ApplicantService){
    $scope.applicants = ApplicantsPromise.data;
    $rootScope.$on('$viewContentLoading',function(){
        console.log("view content loading");
        $rootScope.showLoader = true;
    });

    $scope.showApplicantDetails=function(id){
        //alert("Should show details for applicant with user id:"+id);
        ApplicantService.getApplicantDetails(id).success(
            function(data){
                $rootScope.selectedApplicant=data;
        });
        $('#applicantDetailsModal').modal({

        })
    }

});

admin.controller("DashboardController",function($rootScope,$scope,OverviewService,DashBoardDataPromise){
    $scope.systemData=DashBoardDataPromise.data;
    OverviewService.getSystemStats()
        .success(function(data){
            $scope.systemData = data;
        })
    $rootScope.$on('$viewContentLoading',function(){
        console.log("view content loading");
        $rootScope.showLoader = true;
    });
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
    $scope.data = UsersPromise.data;
    /**
    $scope.gridOptions={
        data:'users',
        multiSelect:false,
        selectedItems:$scope.selectedUser
    };
    $scope.totalUsers=$scope.users.length;
     **/
    $scope.filterUsers=function($event){
        $scope.hideElement = "";
        UserService.getUserLike($event.target.value)
            .success(function(result){
                $scope.data=result;
                $scope.hideElement = "hide-element";
            });
    };

    $rootScope.userTypeList = [
        {id:1,value:"Admin"},
        {id:2,value:"Applicant"}
    ]
    $rootScope.userModel={
        firstname:"",
        lastname:"",
        userType:"",
        email:"",
        conf_email:"",
        password:"",
        conf_password:""
    }

    $rootScope.showEmailMatchError = false;
    $rootScope.showPasswordMatchError = false;
    $rootScope.onConfirm =function ($event){
        switch($event.target.id)
        {
            case "conf_email":
                $rootScope.showEmailMatchError = $event.target.value !== $rootScope.userModel.email?true:false;
                console.log("Emails not the same "+ $rootScope.showEmailMatchError);
            case "conf_password":
                $rootScope.showPasswordMatchError = $event.target.value !== $rootScope.userModel.password?true:false;
                console.log("Passwords not the same "+ $rootScope.showPasswordMatchError);
            case "email":
                $rootScope.showEmailMatchError = $event.target.value !== $rootScope.userModel.conf_email?true:false;
                console.log("Emails not the same "+ $rootScope.showEmailMatchError);
            case "password":
                $rootScope.showPasswordMatchError = $event.target.value !== $rootScope.userModel.conf_password?true:false;
                console.log("Passwords not the same "+ $rootScope.showPasswordMatchError);
            default:
                $rootScope.enableCreateUser = true;
        }
    }

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

    $scope.expandSearch=function(){
        UserService.searchUser(
            $scope.userSearch.applicant_id||"",
            $scope.userSearch.user_type.value||"",
            $scope.userSearch.email||"",
            $scope.userSearch.lastname||"",
            $scope.userSearch.firstname||"")
            .success(function(data){
                $scope.users = data;
            });
    }
    $scope.userSearch={
        applicant_id:"",
        user_type:"",
        firstname:"",
        email:"",
        lastname:""
    };

    $rootScope.deleteUser=function(id)
    {
        console.log(id);
        UserService.deleteUser(id)
            .success(function(data){
                UserService.getUsers()
                    .success(function(data){
                        $scope.data = data
                    });
            }).error(function(data){
                console.log(data)
            });
    }

    $rootScope.showMoreOptions=function(){
        var searchBox = angular.element("#search-box-container");
        var moreOptionBtn = searchBox.find("#moreOptions");
        var moreOptions = searchBox.find(".more-search-controls")
        if(moreOptionBtn.text() === "More Options"){
            moreOptionBtn.text("Less Options");
            searchBox.css("height","270px");
            searchBox.find(".more-search-controls").css("opacity",1);
        }
        else{
            moreOptionBtn.text("More Options")
            searchBox.css("height","74px");
            searchBox.find(".more-search-controls").css("opacity",0);
        }

    };

    $rootScope.createUser=function()
    {
            UserService.createUser(
                $rootScope.userModel.firstname,
                $rootScope.userModel.lastname,
                $rootScope.userModel.userType.value,
                $rootScope.userModel.email,
                $rootScope.userModel.password)
                .success(function(data){
                    UserService.getUsers()
                        .success(function(data){
                            $scope.data = data
                        })
                        .error(function(data){
                            console.log(data);
                        });
                })
                .error(function(data){
                    console.log(data);
                })
    }

    $rootScope.$on('$viewContentLoading',function(){
        console.log("view content loading");
        $rootScope.showLoader = true;
    });
});