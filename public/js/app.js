/**
 * Created by larry Eliemenye
 */

var tarapet=angular.module('tarapet',['ngCookies','ui.router','angularFileUpload']).config(
    function($stateProvider,$urlRouterProvider){
        $stateProvider
            .state('main',{
                url:'/main',
                controller:'TarapetController',
                templateUrl:"../views/t1_m1.html"
            })
            .state('main.dashboard',{
                controller:'DashboardController',
                url:'/dashboard',
                templateUrl:'../views/main-dashboard.html'
            })
            .state('main.startapp',{
                controller:'StartController',
                url:'/startapp',
                templateUrl:'../views/app-start.html',
                resolve:{
                    getApplicationPromise:function($http,SessionService)
                    {
                        return $http.get('main/application',{params:{user_id:SessionService.get('user_id')}}
                        )
                    }
                }
            })
            .state('main.biodata',{
                controller:'BioDataController',
                url:'/biodata',
                templateUrl:'../views/bio-data.html'
            })
            .state('login',{
                url:'/login',
                controller:'LoginController',
                templateUrl:"../views/t1_L1.html"
            })
            .state('signup',{
                url:'/signup',
                controller:"SignupController",
                templateUrl:"../views/t1_s1.html"
            }).state('main.qualifications',{
                controller:'QualificationsController',
                url:'/qualifications',
                templateUrl:'../views/qualifications.html'
            }).state('main.higher-inst',{
                url:'/higher-inst',
                controller:'HigherInstController',
                templateUrl:'../views/higherInst.html'
            }).state('main.profQuali',{
                url:'/profquali',
                controller:'ProfQualiController',
                templateUrl:'../views/profquali.html'
            }).state('main.preview',{
                url:'/preview',
                controller:'PreviewController',
                templateUrl:'../views/preview.html'
            });
    }
);

tarapet.run(function($rootScope,$location,AuthService){
    var routesThatRequireAuth=[
        '/main',
        '/dashboard',
        '/startapp',
        '/biodata',
        '/qualifications',
        '/higher-inst',
        '/profquali'

    ]

    $rootScope.$on('$stateChangeStart',function(event, toState, toParams, fromState, fromParams){
        console.log('Route Changed to :'+toState.url);
        if(_.contains(routesThatRequireAuth, toState.url) && !AuthService.isLoggedIn())
        {
            event.preventDefault();
            $location.path('/login');
        }
    })
})


tarapet.factory('SessionService',function($cookieStore){
    return{
        get:function(key){
            return $cookieStore.get(key);
        },
        set:function(key,value){
            return $cookieStore.put(key,value);
        },
        unset:function(key){
            return $cookieStore.remove(key);
        }
    }
});

tarapet.factory('ApplicationService',function($rootScope,$location,$http,SessionService){
    return{

        addScholarship:function(details){
                $http.post('main/startapp',details)
                    .success(
                    function(data, status, headers, config)
                    {
                        SessionService.set('essay_url',data.essay_url);
                        SessionService.set('reg_number',data.reg_number);
                        SessionService.set('course_of_study',data.course_of_study);
                        SessionService.set('scholarship_type',data.scholarship_type);
                        SessionService.set('government_bounded',data.government_bounded);
                        SessionService.set('already_in_school',data.already_in_school);
                        SessionService.set('has_admission',data.has_admission);
                    })
                    .error(
                    function(data, status, headers, config){

                            console.log("Error Adding stuff to db!");
                    });

        },
        getScholarship:function()
        {

        },
        addBioData:function(biodata){

        },
        submit:function()
        {
            console.log("Submitting all your data. This cannot be undone");
        }
    }
});

tarapet.factory("AuthService",function($rootScope,$location,$http,SessionService){
    var cacheSession=function(){
        SessionService.set('authenticated', true);
    };
    var uncacheSession=function(){
        SessionService.unset('authenticated');
    };


    return{
        login:function(credentials)
        {
            $rootScope.loading=true
            $rootScope.busy_message="Attempting to login....Please wait!!!";

            var login= $http.post("auth/login", credentials );
            login.success(cacheSession);
            return login;
        },
        logout:function()
        {
            var logout = $http.post('/auth/logout');
            logout.success(uncacheSession);
            return logout;
        },
        signup:function(fields)
        {
            $rootScope.loading=true;
            $rootScope.busy_message="Creating your account....Please wait!!!"
            return $http.post("auth/signup",fields);
        },
        isLoggedIn:function()
        {
            return SessionService.get('authenticated');
        }





    }
});

/**tarapet.provider('UserDetailsProvider',function(){

    this.userDetails={};
    this.$get=function(){
        return this.userDetails;
    };

    this.setUserDetails=function(userDetails)
    {
        this.userDetails=userDetails;
    };
});
 **/

tarapet.controller('LoginController',function($scope,$location,AuthService,SessionService){
    $scope.credentials={
        username:"",
        password:"",
        rememberMe:false};

    $scope.loading=false;
    $scope.login=function(){
        $scope.loading=true;
        AuthService.login($scope.credentials).success(function(data){
            SessionService.set('user_id',data.id);
            SessionService.set('full_name',data.full_name);
            $location.path('/main/dashboard');
        }).error(function(){
                $scope.loading=false;
        });
    };
});

tarapet.controller('SignupController',function($scope,$location,AuthService){

    $scope.credentials={
        fullname:"",
        email:"",
        retype_email:"",
        password:"",
        confirm_password:""
    };
    $scope.loading=false;
    $scope.signup=function()
    {
        $scope.loading=true
        AuthService.signup($scope.credentials).success(function(data){
            $location.path('/main');
        }).error(function(){
                $scope.loading=false;
            })
    }
});

tarapet.controller('TarapetController',function($scope,$location,AuthService,SessionService){
    console.log(SessionService.get('applicant_id'));
    $scope.userData={}
    $scope.userData.id=SessionService.get('id');
    $scope.userData.full_name=SessionService.get('full_name');
    $scope.showMainBar=true;
    $scope.applicantStated=false
    $scope.userData.applicant_id="Not yet Availably. Why?"//SessionService.get('applicant_id');


    $scope.logout=function()
    {
           AuthService.logout().success(function(){
               $location.path('/login');
           });
    }
});

tarapet.controller('DashboardController', function($scope,SessionService){
    console.log("from Dashboard Controller"+SessionService.get('applicant_id'));
});

tarapet.controller('StartController',function($rootScope,$scope,$location,$upload,SessionService,ApplicationService,getApplicationPromise){
    $scope.application_data=getApplicationPromise.data;
    $scope.selectedType={}
    $scope.sTypes=
    [
        {name:'PGD',id:1},
        {name:'MSC',id:2},
        {name:'PHD',id:3},
        {name:'DBA',id:4}
    ]
    $scope.showError=false;

    //search scholarship type array for Type Code

    $scope.startDetails={
        user_id:SessionService.get('user_id'),
        scholarship_type:_.find($scope.sTypes,function(type){
            return type.name==getApplicationPromise.data.scholarship_type;
        }),
        course_of_study:getApplicationPromise.data.course_of_study,
        ready_to_bound:getApplicationPromise.data.government_bounded=='YES'?true:false,
        already_in_school:getApplicationPromise.data.already_in_school=='YES'?true:false,
        has_an_admission:getApplicationPromise.data.has_admission=='YES'?true:false,
        path_to_essay:getApplicationPromise.data.essay_url
    }

    $scope.start=function()
    {
        $scope.showError=false;
        if($scope.startDetails.scholarship_type
            && $scope.startDetails.course_of_study
            && $scope.startDetails.path_to_essay)
        {
            ApplicationService.addScholarship($scope.startDetails);
            $location.path('/main/biodata');
        }
        else
        {
            $scope.showError=true;
        }

    }

    $scope.onFileSelect=function($files)
    {
        var handleFileSucess=function(data,status,headers,config)
        {
            $scope.uploadResult=data.message;
            $scope.startDetails.path_to_essay=data.filepath;
            $scope.uploading=false;
            $rootScope.$$phase || $rootScope.$apply();
        }
        $scope.uploading=true;
        for(var i =0;i<$files.length;i++)
        {
            var $file=$files[i];
            $scope.upload=$upload.upload({
                url:'main/upload',
                method:'post',
                file:$file,
                progress:function(evt)
                {
                    console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
                }
            }).success(handleFileSucess).error(function(){
                    console.log("Shit happened!!!");
                });
        }
    }

});

tarapet.controller('BioDataController',function($scope,$location,ApplicationService){

    $scope.gender=[
        {id:1,value:'Male'},
        {id:2,value:'Female'}
    ];
    $scope.biodata={
        firstnme:null,
        middlename:null,
        surname:null,
        dateofbirth:null,
        placeofbirth:null,
        gender:null,
        phone:null,
        email:null,
        compoundname:null,
        residencialAdd:null,
        clan:null,
        lga:null,
        state:null,
        village:null

    };
    $scope.gotoQualifications=function()
    {
        $location.path('/main/qualifications');
    }

});

tarapet.controller('QualificationsController',function($scope,$location,ApplicationService){
    $scope.exams=[
        {id:1,name:'WAEC'},
        {id:2,name:'NECO'},
        {id:3,name:'GSCE'}
    ];


    $scope.gotoHigherInst=function()
    {
        $location.path('/main/higher-inst');
    }
});
tarapet.controller('HigherInstController',function($scope,$location,ApplicationService){
    $scope.gotoProfQuali=function()
    {
        $location.path('/main/profquali');
    }
});
tarapet.controller('ProfQualiController',function($scope,$location,ApplicationService){
    $scope.saveAndPreview=function()
    {
        $location.path('/main/preview');
    }
});
tarapet.controller('PreviewController',function($scope,$location,ApplicationService){
    $scope.submitApplication=function()
    {
        ApplicationService.submit();
    }
});


