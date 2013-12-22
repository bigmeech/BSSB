/**
 * Created by larry Eliemenye
 */

var tarapet=angular.module('tarapet',['ngCookies','ui.router','angularFileUpload']).config(
    function( $stateProvider,$urlRouterProvider){
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
                templateUrl:'../views/app-start.html'
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
    var routesThatRequireAuth=['/main','/login','/dashboard']

    $rootScope.$on('$stateChangeStart',function(event, toState, toParams, fromState, fromParams){
        console.log('Route Changed to :'+$location.url());
        if(_.contains(routesThatRequireAuth, $location.path()) && !AuthService.isLoggedIn())
        {
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

tarapet.factory('ApplicationService',function($rootScope,$location,$http){
    return{
        addScholarship:function(details){
            console.log(details);
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
            login.success(function(){
                SessionService.set('authenticated', true);
            });
            return login;
        },
        logout:function()
        {
            var logout = $http.post('/auth/logout');
            logout.success(function(){
                SessionService.unset('authenticated');
            });
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
            SessionService.set('userdata',data.id);
            SessionService.set('full_name',data.full_name);
            SessionService.set('applicant_id',data.applicant_id);
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

tarapet.controller('StartController',function($scope,$location,$upload,SessionService,ApplicationService){
    console.log("Now in Start"+SessionService.get('applicant_id'));
    $scope.selectedType={}
    $scope.sTypes=
    [
        {name:'PGD',id:1},
        {name:'MSC',id:2},
        {name:'PHD',id:3},
        {name:'DBA',id:4}
    ]
    $scope.onFileSelect=function($files)
    {
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
            }).success(function(data,status,headers,config){

                    console.log("File Uploaded sucessfully: "+data.message);
                    $scope.uploadResult=data.message;
                    $scope.startDetails.path_to_essay=data.filepath;
                    $scope.uploading=false;
                }).error(function(){
                    console.log("Shit happened!!!");
                });
        }
    }
    $scope.showError=false;
    $scope.startDetails={
        scholarship_type:null,
        course_of_study:null,
        ready_to_bound:false,
        already_in_school:false,
        has_an_admission:false,
        path_to_essay:null
    }

    $scope.start=function()
    {
        $scope.showError=false;
        if($scope.startDetails.scholarship_type
            && $scope.startDetails.course_of_study
            && $scope.startDetails.ready_to_bound
            && $scope.startDetails.already_in_school
            && $scope.startDetails.has_an_admission
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


