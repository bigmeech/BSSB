/**
 * Created by larry Eliemenye
 */

var tarapet=angular.module('tarapet',['ngCookies','ui.router','angularFileUpload']).config(
    function($provide,$stateProvider,$urlRouterProvider,$httpProvider){
        $urlRouterProvider.otherwise('/main/dashboard')
        $stateProvider
            .state('main',{
                url:'/main',
                controller:'BSSBController',
                templateUrl:"../views/t1_m1.html",
                resolve:{
                    getAppDataPromise:function($http,SessionService)
                    {
                        return $http.get('main/getAppData',{
                            params:{
                                user_id:SessionService.get('user_id')
                            }
                        });
                    }
                }
            })
            .state('main.dashboard',{
                controller:'DashboardController',
                url:'/dashboard',
                templateUrl:'../views/main-dashboard.html',
                resolve:{
                    getAppDataPromise:function($http,SessionService)
                    {
                        return $http.get('main/getAppData',{
                            params:{
                                user_id:SessionService.get('user_id')
                            }
                        });
                    }
                }
            })
            .state('main.startapp',{
                controller:'StartController',
                url:'/startapp',
                templateUrl:'../views/app-start.html',
                resolve:{
                    getApplicationPromise:function($http,SessionService)
                    {
                        return $http.get(
                            'main/application',{
                                params:{
                                    user_id:SessionService.get('user_id')
                                }
                            }
                        )
                    }
                }

            })
            .state('main.biodata',{
                controller:'BioDataController',
                url:'/biodata',
                templateUrl:'../views/bio-data.html',
                resolve:{
                    getBioDataPromise:function($http,SessionService)
                    {
                        return $http.get('main/fetchbio',{
                            params:{
                                user_id:SessionService.get('user_id')
                            }
                        })
                    }
                }
            })
            .state('login',{
                url:'/login',
                controller:'LoginController',
                templateUrl:"../views/t1_L1.html",

            })
            .state('signup',{
                url:'/signup',
                controller:"SignupController",
                templateUrl:"../views/t1_s1.html"
            }).state('main.qualifications',{
                controller:'QualificationsController',
                url:'/qualifications',
                templateUrl:'../views/qualifications.html',
                resolve:{
                    getBasicQualificationPromise:function($http,SessionService){
                        return $http.get('main/getBasicQualifications',{
                            params:{
                                user_id:SessionService.get('user_id')
                            }
                        })
                    }
                }
            }).state('main.higher-inst',{
                url:'/higher-inst',
                controller:'HigherInstController',
                templateUrl:'../views/higherInst.html',
                resolve:{
                    getHigherInstPromise:function($http,SessionService)
                    {
                        return $http.get('main/higher-institution',{
                            params:{
                                user_id:SessionService.get('user_id')
                            }
                        });

                    }

                }
            }).state('main.profQuali',{
                url:'/profquali',
                controller:'ProfQualiController',
                templateUrl:'../views/profquali.html',
                resolve:{
                    getProfQualiPromise:function($http,SessionService)
                    {
                        return $http.get('main/getProfQuali',{
                            params:{
                                user_id:SessionService.get('user_id')
                            }
                        });
                    }
                }
            }).state('main.preview',{
                url:'/preview',
                controller:'PreviewController',
                templateUrl:'../views/preview.html',
                resolve:{
                    getPreviewPromise:function($http,SessionService)
                    {
                        return $http.get('main/getPreview',{
                            params:{
                                user_id:SessionService.get('user_id')
                            }
                        });
                    }
                }
            });

        //function($provide){
            $httpProvider.responseInterceptors.push('myHTTPInterceptor');

            $provide.factory('myHTTPInterceptor', function($q){
                return function(promise)
                {
                    return promise.then(function(response){
                        console.log(response.status)
                        //console.log(response.headers)
                        return response;
                    })
                }
            });
        //}
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

        if(_.contains(routesThatRequireAuth, toState.url) && !AuthService.isLoggedIn())
        {
            event.preventDefault();
            $rootScope.loadStart=true;
            $rootScope.$broadcast('viewLoadError');
            $location.path('/login');
        }
        else if(toState.url === '/login' && AuthService.isLoggedIn()){
            event.preventDefault();
            $location.path('/dashboard');
            console.log("forcefully going to login")
        }
        else{
            $rootScope.loadStart=true;
        }

    })

    $rootScope.$on('viewLoadError',function(event, viewConfig){
        console.log(event);
        $rootScope.loadStart=false;
    })

    $rootScope.$on('$viewContentLoading',function(event, viewConfig){
        console.log("View is loading");
        $rootScope.loadStart=true;
    });

    $rootScope.$on('$viewContentLoaded',function(event, viewConfig){
        console.log("View finsihed loading");
        $rootScope.loadStart=false;
    });
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

tarapet.factory('ApplicationDataService',function($http,$cookieStore,SessionService){

    $http.get('main/getAppData',
    {
        params:{
            user_id:SessionService.get('user_id')
        }

    }).success(function(data){
                SessionService.set('appProgress', data.app_progress)
                SessionService.set('scholarship_form_complete', data.scholarship_form_complete)
                SessionService.set('biodata_form_complete', data.biodata_form_complete)
                SessionService.set('basic_quali_form_complete', data.basic_quali_form_complete)
                SessionService.set('higher_inst_form_complete', data.higher_inst_form_complete)
                SessionService.set('prof_quali_form_complete', data.prof_quali_form_complete)
        })
    return{
        getAppProgress:function()
        {
            return SessionService.get('appProgress');
        },
        setAppProgress:function(progress)
        {
            return SessionService.put('appProgress',progress)
        },

        getSchFormComplete:function()
        {
            return SessionService.get('sch_form_complete');
        },
        setSchFormComplete:function(value)
        {
            return SessionService.set('sch_form_complete',value);
        },

        getBioDataFormComplete:function()
        {
            return SessionService.get('biodsta_form_complete');
        },
        setBioDataFormComplete:function(value)
        {
            return SessionService.set('biodsta_form_complete',value);
        },

        getBasicQualiFormComplete:function()
        {
            return SessionService.get('basic_quali_form_complete');
        },
        setBasicQualiFormComplete:function(value)
        {
            return SessionService.set('basic_quali_form_complete',value);
        },

        getHigherInstFormComplete:function()
        {
            return SessionService.get('higher_inst_form_complete');
        },
        setHigherInstFormComplete:function(value)
        {
            return SessionService.set('higher_inst_form_complete',value);
        },

        getProfQualiFormComplete:function()
        {
            return SessionService.get('prof_quali_form_complete');
        },
        setProfQualiFormComplete:function(value)
        {
            return SessionService.set('prof_quali_form_complete',value);
        }

    }
})

tarapet.factory('ApplicationService',function($rootScope,$location,$http,SessionService){
    return{

        addScholarship:function(details){
                return $http.post('main/startapp',details);

        },
        addBioData:function(biodata){
            biodata.user_id=SessionService.get('user_id');
            return $http.post('main/biodata',biodata)

        },
        addBasicQualificastions:function(qualifications)
        {
            qualifications.user_id=SessionService.get('user_id');
            return $http.post('main/qualifications',qualifications)

        },
        addHigherInst:function(higherInstDetails){
            higherInstDetails.user_id=SessionService.get('user_id');
            return $http.post('main/higher-inst',higherInstDetails);

        },
        addProfQuali:function(proQualiDetails)
        {
            proQualiDetails.user_id=SessionService.get('user_id');
            $http.post('main/professional-qualifications',proQualiDetails)

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
        },
        changePassword:function(passwords)
        {
            passwords.id = SessionService.get('user_id');
            return $http.post("auth/changePassword",passwords);
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

tarapet.controller('LoginController',function($scope,$http,$location,AuthService,SessionService,ApplicationDataService){
    $scope.credentials={
        username:"",
        password:"",
        rememberMe:false};

    $scope.loading=false;
    $scope.login=function(){
        $scope.loading=true;
        AuthService.login($scope.credentials).success(function(data){
            SessionService.set('user_id',data.id);
            SessionService.set('firstname',data.firstname);
            SessionService.set('lastname',data.lastname);
            //get application data from server and save it to cookie, the
            //use cookie to set UI
            console.log(ApplicationDataService.getAppProgress())
            $location.path('/main/dashboard');
        }).error(function(data){
                $scope.loading=false;
                $scope.error=data.flash;
        });
    };
});

tarapet.controller('SignupController',function($scope,$location,AuthService,SessionService){

    $scope.credentials={
        firstname:"",
        lastname:"",
        email:"",
        retype_email:""
    };

    $scope.hideSignup=false;
    $scope.signupComplete=false;
    $scope.loading=false;
    $scope.signup=function()
    {
        $scope.loading=true
        $scope.signupComplete=false;
        $scope.hideSignup=true;
        AuthService.signup($scope.credentials).success(function(data){
            $scope.loading=false;
            $scope.signupComplete=true;
            $scope.hideSignup=true;
            SessionService.set('user_id',data.id);
            SessionService.set('firstname',data.firstname);
            SessionService.set('lastname',data.lastname);
            SessionService.set('email',data.email);

            $scope.email=data.email

            $rootScope.$$phase || $rootScope.$apply();
        }).error(function(data){
                $scope.loading=false;
                $scope.signupComplete=false;
                $scope.hideSignup=false;
                $scope.error=data.message
                $rootScope.$$phase || $rootScope.$apply();
            })
    }
});

tarapet.controller('BSSBController',function($rootScope,$scope,$location,AuthService,SessionService,ApplicationDataService,getAppDataPromise){
    console.log("Applicationdata: "+getAppDataPromise.data);
    console.log(SessionService.get('applicant_id'));
    $scope.userData={};
    $rootScope.appData={};
    $scope.userData.firstname=SessionService.get('firstname');
    $scope.userData.lastname=SessionService.get('lastname');
    $scope.userData.email=SessionService.get('email');
    $scope.showMainBar=true;
    $scope.applicantStated=false
    $scope.userData.applicant_id=getAppDataPromise.data.reg_id||"Not yet Availably. Why?"//SessionService.get('applicant_id');

    $rootScope.appData.appProgress="style=width:"+SessionService.get('appProgress')+"%";
    $rootScope.appData.scholarship_form_complete=SessionService.get('scholarship_form_complete') || "true";
    $rootScope.appData.biodata_form_complete=SessionService.get('biodata_form_complete') || "true";
    $rootScope.appData.basic_quali_form_complete=SessionService.get('basic_quali_form_complete') || "true";
    $rootScope.appData.higher_inst_form_complete=SessionService.get('higher_inst_form_complete') || "true";
    $rootScope.appData.prof_quali_form_complete=SessionService.get('prof_quali_form_complete') || "true";
    $rootScope.appData.reg_id = getAppDataPromise.data.reg_id
    $scope.reg_id_tip = $rootScope.appData.reg_id ? null : "To have an application ID, you have to complete your application process and submit your details. We use this uniquely generated ID to identify your application"

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
    if(getApplicationPromise.data.essay_url)
    {
        var essay_link=getApplicationPromise.data.essay_url;
        $scope.application_data=getApplicationPromise.data;
        $scope.application_data.essay_url=essay_link.substring(essay_link.lastIndexOf('\\')+1);
    }
    $scope.loading=false;

    $scope.$on('$viewContentLoading',function(event, viewConfig){
        $scope.loadComplete=true;
    })

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

    $scope.save = function()
    {
        $scope.showSave = false;
        $scope.showSaveError = false;
        $scope.loading=true;
        $scope.showError=false;
        if($scope.startDetails.scholarship_type
            && $scope.startDetails.course_of_study
            && $scope.startDetails.path_to_essay){
            ApplicationService.addScholarship($scope.startDetails)
                .success(
                function(data, status, headers, config)
                {
                    SessionService.set('scholarship_form_complete',true);
                    $scope.showSave=true;
                })
                .error(
                function(data, status, headers, config){
                    $scope.showSaveError = true;
                });
        }
        else
        {
            $scope.showError=true;
        }

    }

    $scope.onFileSelect=function($files)
    {
        $scope.pathReturned=false;
        var handleFileSucess=function(data,status,headers,config)
        {
            console.log('Whats:'+data.message);
            $scope.filename=data.filename;
            $scope.pathReturned=true;
            $scope.startDetails.path_to_essay=data.filepath;
            $scope.uploading=false;
            $rootScope.$$phase || $rootScope.$apply();
            $scope.uploadErrorMessage=null;
        }
        var handleFileError=function(data,status,headers,config){
            $scope.uploadErrorMessage=data.message;
        }
        $scope.uploading=true;
        for(var i =0;i<$files.length;i++)
        {
            var $file=$files[i];
            $scope.upload=$upload.upload({
                url:'main/upload',
                method:'post',
                file:$file,
                data:{
                    file_type:'essay',
                    user_id:SessionService.get('user_id')
                },
                progress:function(evt)
                {
                    console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
                }
            }).success(handleFileSucess).error(handleFileError);
        }
    }

});

tarapet.controller('BioDataController',function($upload,$scope,$location,ApplicationService,getBioDataPromise,SessionService){


    $scope.gender=[
        {id:1,value:'Male'},
        {id:2,value:'Female'}
    ];
    $scope.uploadingPhoto = false;
    $scope.loading=false;
    $scope.bioData={
        firstName:getBioDataPromise.data.firstName,
        middleName:getBioDataPromise.data.middleName,
        surname:getBioDataPromise.data.surname,
        dob:getBioDataPromise.data.dob,
        pob:getBioDataPromise.data.pob,
        gender:_.find($scope.gender,function(gender){
            return gender.value==getBioDataPromise.data.gender;
        }),
        phone:getBioDataPromise.data.phone,
        passportPhoto:getBioDataPromise.data.passportPhoto,
        email:getBioDataPromise.data.email,
        compoundname:getBioDataPromise.data.compoundName,
        residentialAddress:getBioDataPromise.data.residentialAddress,
        mFirstName:getBioDataPromise.data.mFirstName,
        mSurname:getBioDataPromise.data.mSurname,
        maidenName:getBioDataPromise.data.maidenName,
        mVillage:getBioDataPromise.data.mVillage,
        mClan:getBioDataPromise.data.mClan,
        mLGA:getBioDataPromise.data.mLGA,
        pFirstName:getBioDataPromise.data.pFirstName,
        pSurname:getBioDataPromise.data.pSurname,
        paternalName:getBioDataPromise.data.paternalName,
        pVillage:getBioDataPromise.data.pVillage,
        pClan:getBioDataPromise.data.pClan,
        pLGA:getBioDataPromise.data.pLGA

    };
    $scope.save=function()
    {
        $scope.showSave = false;
        $scope.showSaveError = false;
        $scope.loading=true;
        ApplicationService.addBioData($scope.bioData)
            .success(function(data, status, headers, config)
            {
                SessionService.set('biodata_form_complete',true);
                $scope.showSave=true;
                $scope.showSaveError=false;
            })
            .error(function(data, status, headers, config){
                $scope.showSaveError=true;
                $scope.showSave=false;
            });
    }

    $scope.uploadPhoto = function()
    {
        //$scope.uploadingPhoto = true;

        var fileuploader = angular.element("#passfile");
        //console.log(fileuploader);
        fileuploader.on('click',function(){
            console.log("File upload triggered programatically");
        })
        fileuploader.trigger('click')
    }



    $scope.onPhotoSelect = function(files,type)
    {
        $scope.uploadingPhoto = true
        $scope.pathReturned=false;
        var handleFileSucess=function(data,status,headers,config)
        {
            var imgArea = angular.element('<img width="234" height="234"/>');
            var imgContainer = angular.element('#imgArea');
            imgArea.attr('src',data.url);
            imgArea.css('height','227px');
            imgArea.css('width','227px');
            imgArea.css('border','3px Solid #fff');
            imgContainer.empty();
            imgContainer.append(imgArea);

            $scope.pathReturned=true;
            $scope.uploadingPhoto = false;
            $scope.bioData.passportPhoto=data.url;
        }
        var handleFileError=function(data,status,headers,config){
            $scope.uploadErrorMessage=data.message;
        }
        for(var i =0;i<files.length;i++)
        {
            var file=files[i];
            $scope.upload=$upload.upload({
                url:'main/upload',
                method:'post',
                file:file,
                data:{
                    file_type:type,
                    user_id:SessionService.get('user_id')
                }
            }).success(handleFileSucess).error(handleFileError);
        }
    }

    if($scope.bioData.passportPhoto)
    {
        var imgArea = angular.element('<img width="234" height="234"/>');
        var imgContainer = angular.element('#imgArea');
        imgArea.attr('src',$scope.bioData.passportPhoto);
        imgArea.css('height','227px');
        imgArea.css('width','227px');
        imgArea.css('border','3px Solid #fff');
        imgContainer.empty();
        imgContainer.append(imgArea);
    }

});

tarapet.controller('QualificationsController',function($scope,$rootScope,$location,$upload,SessionService,ApplicationService,getBasicQualificationPromise){
    $scope.qualificationData=getBasicQualificationPromise.data;

    $scope.s1_filename = !getBasicQualificationPromise.data.s1_cert_url ? null : getBasicQualificationPromise.data.s1_cert_url.substring
        ($scope.qualificationData.s1_cert_url.lastIndexOf('\\')+1);
    $scope.s2_filename = !getBasicQualificationPromise.data.s2_cert_url ? null : getBasicQualificationPromise.data.s2_cert_url.substring
        (getBasicQualificationPromise.data.s2_cert_url.lastIndexOf('\\')+1);
    $scope.jamb_filename = !getBasicQualificationPromise.data.jamb_cert_url ? null : getBasicQualificationPromise.data.jamb_cert_url.substring
        (getBasicQualificationPromise.data.jamb_cert_url.lastIndexOf('\\')+1);
    $scope.aLevels_filename = !getBasicQualificationPromise.data.a_cert_url ? null : getBasicQualificationPromise.data.a_cert_url.substring
        (getBasicQualificationPromise.data.a_cert_url.lastIndexOf('\\')+1);

    $scope.exams=[
        {id:1,name:'WAEC'},
        {id:2,name:'NECO'},
        {id:3,name:'GSCE'}
    ];

    $scope.loading=false;
    $scope.qualiDetails={
            s1_exam: _.find($scope.exams,function(exam){
                return exam.name == getBasicQualificationPromise.data.s1_exam
            }),
            s1_exam_number:getBasicQualificationPromise.data.s1_exam_number,
            s1_center_name:getBasicQualificationPromise.data.s1_center_name,
            s1_exam_year:getBasicQualificationPromise.data.s1_exam_year,
            s1_year_admitted:getBasicQualificationPromise.data.s1_year_admitted,
            s1_credits:getBasicQualificationPromise.data.s1_credits,
            s1_year_graduated:getBasicQualificationPromise.data.s1_year_graduated,
            s1_subAndGrades:getBasicQualificationPromise.data.s1_subAndGrades,
            s1_cert_url:getBasicQualificationPromise.data.s1_cert_url,
            s2_exam:_.find($scope.exams,function(exam){
                return exam.name == getBasicQualificationPromise.data.s2_exam
            }),
            s2_exam_number:getBasicQualificationPromise.data.s2_exam_number,
            s2_center_name:getBasicQualificationPromise.data.s2_center_name,
            s2_exam_year:getBasicQualificationPromise.data.s2_exam_year,
            s2_year_admitted:getBasicQualificationPromise.data.s2_year_admitted,
            s2_credits:getBasicQualificationPromise.data.s2_credits,
            s2_year_graduated:getBasicQualificationPromise.data.s2_year_graduated,
            s2_subAndGrades:getBasicQualificationPromise.data.s2_subAndGrades,
            s2_cert_url:getBasicQualificationPromise.data.s2_cert_url,

            a_exam:getBasicQualificationPromise.data.a_exam || "",
            a_center_name:getBasicQualificationPromise.data.a_center_name ||"",
            a_credits:getBasicQualificationPromise.data.a_credits || "",
            a_exam_number:getBasicQualificationPromise.data.a_exam_number || "",
            a_subAndGrades:getBasicQualificationPromise.data.a_subAndGrades || "",
            a_cert_url:getBasicQualificationPromise.data.a_cert_url,

            jamb_center_name:getBasicQualificationPromise.data.jamb_center_name || "",
            jamb_exam_number:getBasicQualificationPromise.data.jamb_exam_number || "",
            jamb_exam_year:getBasicQualificationPromise.data.jamb_exam_year || "",
            jamb_total_score:getBasicQualificationPromise.data.jamb_total_score || "",
            jamb_subAndScore:getBasicQualificationPromise.data.jamb_subAndScore || "",
            jamb_cert_url:getBasicQualificationPromise.data.jamb_cert_url || ""



    }

    $scope.onFileSelect=function($files,type)
    {
        switch(type)
        {
            case "sitting1":
                $scope.uploadingSitting1=true;
                break;
            case "sitting2":
                $scope.uploadingSitting2=true;
                break;
            case "aLevels":
                $scope.uploadingALevels=true;
                break;
            case "jamb":
                $scope.uploadingJamb=true;
                break;
        }

        $scope.pathReturned=false;
        var handleFileSucess=function(data,status,headers,config)
        {
            console.log('Whats:'+data.message);
            switch(data.type)
            {
                case "sitting1":
                    $scope.qualiDetails.s1_cert_url=data.filepath;
                    $scope.s1_filename=data.filename;
                    $scope.s1_url=data.url;
                    break;
                case "sitting2":
                    $scope.qualiDetails.s2_cert_url=data.filepath;
                    $scope.s2_filename=data.filename;
                    $scope.s2_url=data.url;
                    break;
                case "jamb":
                    $scope.qualiDetails.jamb_cert_url=data.filepath;
                    $scope.jamb_filename=data.filename;
                    $scope.jamb_url=data.url
                    break;
                case "aLevels":
                    $scope.qualiDetails.a_cert_url=data.filepath;
                    $scope.aLevels_filename=data.filename;
                    $scope.aLevels_url=data.url;
            }
            $scope.pathReturned=true;
            $scope.qualiDetails.s2_cert_url=data.filepath;
            $scope.uploadErrorMessage=null;

            $scope.uploadingSitting1=false;
            $scope.uploadingSitting2=false;
            $scope.uploadingALevels=false;
            $scope.uploadingJamb=false;
            $rootScope.$$phase || $rootScope.$apply();
        }
        var handleFileError=function(data,status,headers,config){
            $scope.uploadErrorMessage=data.message;
        }
        $scope.uploading=true;
        for(var i =0;i<$files.length;i++)
        {
            var $file=$files[i];
            $scope.upload=$upload.upload({
                url:'main/upload',
                method:'post',
                file:$file,
                data:{
                    file_type:type,
                    user_id:SessionService.get('user_id')
                },
                progress:function(evt)
                {
                    console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
                }
            }).success(handleFileSucess).error(handleFileError);
        }
    }


    $scope.save = function(){
        $scope.showSave = false;
        $scope.showSaveError = false
        $scope.loading=true;
        ApplicationService.addBasicQualificastions($scope.qualiDetails)
            .success(
            function(data, status, headers, config)
            {
                SessionService.set('quali_details_complete',true);
                $scope.showSave = true;
                $scope.showSaveError = false;
            })
            .error(
            function(data, status, headers, config)
            {
                $scope.showSaveError = true;
                $scope.showSave = false;
            }
        );
    }
});
tarapet.controller('HigherInstController',function($scope,$rootScope,$location,$upload,ApplicationService,SessionService,getHigherInstPromise){

    $scope.grade_types=[
        {id:1,value:'First Class'},
        {id:2,value:'Second Class Upper'},
        {id:3,value:'Second Class Lower'},
        {id:4,value:'Third Class'}
    ]


    $scope.uploadCert1=function()
    {
        var cert1File = angular.element("#cert1File");
        cert1File.on('click',function(){
            console.log('Programatically triggering cert 1 file upload!!!');
        });
        cert1File.trigger('click');
    }

    $scope.uploadCert2=function()
    {
        var cert2File = angular.element("#cert2File");
        cert2File.on('click',function(){
            console.log('Programatically triggering cert 2 file upload!!!');
        });
        cert2File.trigger('click');
    }
    $scope.nysc_filename=!getHigherInstPromise.data.nysc_cert ? null : getHigherInstPromise.data.nysc_cert.substring
        (getHigherInstPromise.data.nysc_cert.lastIndexOf('\\')+1);
    $scope.inst1_filename=!getHigherInstPromise.data.inst1_cert_url ? null : getHigherInstPromise.data.inst1_cert_url.substring
        (getHigherInstPromise.data.inst1_cert_url.lastIndexOf('\\')+1);
    $scope.inst2_filename=!getHigherInstPromise.data.inst2_cert_url ? null : getHigherInstPromise.data.inst2_cert_url.substring
        (getHigherInstPromise.data.inst2_cert_url.lastIndexOf('\\')+1);

    $scope.higherInstDetails={
            inst1_name:getHigherInstPromise.data.inst1_name,
            inst1_cos:getHigherInstPromise.data.inst1_cos,
            inst1_duration:getHigherInstPromise.data.inst1_duration,
            inst1_cert:getHigherInstPromise.data.inst1_cert,
            inst1_admission_year:getHigherInstPromise.data.inst1_admission_year,
            inst1_exp_grad_year:getHigherInstPromise.data.inst1_exp_grad_year,
            inst1_grad_year:getHigherInstPromise.data.inst1_grad_year,
            inst1_grade:getHigherInstPromise.data.inst1_grade,
            inst1_cert_url:getHigherInstPromise.data.inst1_cert_url,
            inst1_reason:getHigherInstPromise.data.inst1_reason,

            inst2_name:getHigherInstPromise.data.inst2_name,
            inst2_cos:getHigherInstPromise.data.inst2_cos,
            inst2_duration:getHigherInstPromise.data.inst2_duration,
            inst2_cert:getHigherInstPromise.data.inst2_cert,
            inst2_admission_year:getHigherInstPromise.data.inst2_admission_year,
            inst2_exp_grad_year:getHigherInstPromise.data.inst2_exp_grad_year,
            inst2_grad_year:getHigherInstPromise.data.inst2_grad_year,
            inst2_grade:getHigherInstPromise.data.inst2_grade,
            inst2_cert_url:getHigherInstPromise.data.inst2_cert_url,
            inst2_reason:getHigherInstPromise.data.inst2_reason,

            nysc_state:getHigherInstPromise.data.nysc_state,
            nysc_call_up:getHigherInstPromise.data.nysc_call_up,
            nysc_batch:getHigherInstPromise.data.nysc_batch,
            nysc_year:getHigherInstPromise.data.nysc_year,
            nysc_completion_year:getHigherInstPromise.data.nysc_completion_year,
            nysc_exempted:getHigherInstPromise.data.nysc_exempted=="YES"?true:false,
            reason_exempted:getHigherInstPromise.data.reason_exempted,
            nysc_cert:getHigherInstPromise.data.nysc_cert
    }

    $scope.onFileSelect=function($files,type){
        switch(type)
        {
            case "inst1":
                $scope.uploadingInst1=true;
                break;
            case "inst2":
                $scope.uploadingInst2=true;
                break;
            case "nysc":
                $scope.uploadingNYSC=true;
                break

        }
        function handleUploadSucess(data,status,headers,config)
        {
            switch(data.type)
            {
                case "inst1":
                    $scope.inst1_filename=data.filename;
                    $scope.inst1_filepath=data.filepath;
                    $scope.higherInstDetails.inst1_cert_url=data.filepath;
                    break;
                case "inst2":
                    $scope.inst2_filename=data.filename;
                    $scope.inst2_filepath=data.filepath;
                    $scope.higherInstDetails.inst2_cert_url=data.filepath;
                    break;
                case "nysc":
                    $scope.nysc_filename=data.filename;
                    $scope.nysc_filepath=data.filepath;
                    $scope.higherInstDetails.nysc_cert=data.filepath;
                    break;

            }
            $scope.uploadingInst1=false;
            $scope.uploadingInst2=false;
            $scope.uploadingNYSC=false;
            $rootScope.$$phase || $rootScope.$apply();
        }

        function handleUploadError(data,status,headers,config)
        {
            console.log(data);
        }
        for(var i =0;i<$files.length;i++)
        {
            var $file=$files[i];
            $scope.upload=$upload.upload({
                url:'main/upload',
                method:'post',
                file:$file,
                data:{
                    file_type:type,
                    user_id:SessionService.get('user_id')
                },
                progress:function(evt)
                {
                    console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
                }
            }).success(handleUploadSucess).error(handleUploadError);
        }
    }
    $scope.save=function()
    {
        $scope.showSave = false;
        $scope.showSaveError = false;
        ApplicationService.addHigherInst($scope.higherInstDetails)
            .success(
            function(data, status, headers, config)
            {
                SessionService.set('hInst_details_complete',true);
                $scope.showSave = true;
                $scope.showSaveError = false;
            })
            .error(function(data, status, headers, config)
            {
                SessionService.set('hInst_details_complete',false);
                $scope.showSave = false;
                $scope.showSaveError = true;
            })
    }
});
tarapet.controller('ProfQualiController',function($scope,$rootScope,$location,$upload,ApplicationService,SessionService,getProfQualiPromise){

    $scope.inst1_cert_filename=!getProfQualiPromise.data.inst1_cert_url ? null : getProfQualiPromise.data.inst1_cert_url.substring
        (getProfQualiPromise.data.inst1_cert_url.lastIndexOf('\\')+1);
    $scope.inst2_cert_filename=!getProfQualiPromise.data.inst2_cert_url ? null : getProfQualiPromise.data.inst2_cert_url.substring
        (getProfQualiPromise.data.inst2_cert_url.lastIndexOf('\\')+1);

    $scope.profQualiDetails={
        inst1_name:getProfQualiPromise.data.inst1_name,
        inst1_license:getProfQualiPromise.data.inst1_license,
        inst1_year:getProfQualiPromise.data.inst1_year,
        inst1_designation:getProfQualiPromise.data.inst1_designation,
        inst1_cert_url:getProfQualiPromise.data.inst1_cert_url,

        inst2_name:getProfQualiPromise.data.inst2_name,
        inst2_license:getProfQualiPromise.data.inst2_license,
        inst2_year:getProfQualiPromise.data.inst2_year,
        inst2_designation:getProfQualiPromise.data.inst2_designation,
        inst2_cert_url:getProfQualiPromise.data.inst2_cert_url,

        ref_full_name:getProfQualiPromise.data.ref_full_name,
        ref_occupation:getProfQualiPromise.data.ref_occupation,
        ref_phone_number:getProfQualiPromise.data.ref_phone_number,
        ref_address:getProfQualiPromise.data.ref_address,
        ref_email:getProfQualiPromise.data.ref_email
    }

    $scope.onFileSelect = function($files,type)
    {
        switch(type)
        {
            case "prof1_cert":
                $scope.uploadingInst1=true;
                break;
            case "prof2_cert":
                $scope.uploadingInst2=true;
                break;
        }

        function uploadFilesSucess(data,status,headers,config)
        {
            switch(type)
            {
                case "prof1_cert":
                    $scope.profQualiDetails.inst1_cert_url=data.filepath;
                    $scope.inst1_cert_filename=data.filename;
                    break;
                case "prof2_cert":
                    $scope.profQualiDetails.inst2_cert_url=data.filepath;
                    $scope.inst2_cert_filename=data.filename;
                    break;
            }

            //stop progress indicator for file uploads from displaying
            $scope.uploadingInst1=false;
            $scope.uploadingInst2=false;

            //apply changes
            $rootScope.$$phase || $rootScope.$apply();
        }

        function uploadFilesErrors(data,status,headers,config)
        {
            console.log(data.message);
        }

        for(var i =0;i<$files.length;i++)
        {
            var $file=$files[i];
            $scope.upload=$upload.upload({
                url:'main/upload',
                method:'post',
                file:$file,
                data:{
                    file_type:type,
                    user_id:SessionService.get('user_id')
                },
                progress:function(evt)
                {
                    console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
                }
            }).success(uploadFilesSucess).error(uploadFilesErrors);
        }
    }

    $scope.save=function()
    {
        $scope.showSave = false;
        $scope.showSaveEroor =  false;
        ApplicationService.addProfQuali($scope.profQualiDetails)
            .success(function(data, status, headers, config)
            {
                SessionService.set('prof_details_complete',true);
                $scope.showSave  = true;
                $scope.showSaveError = false;
            }).error(function(data, status, headers, config)
                {
                    SessionService.set('prof_details_complete',false);
                    $scope.showSave  = false;
                    $scope.showSaveError = true;
                });
    }
});
tarapet.controller('PreviewController',function($scope,$location,ApplicationService,getPreviewPromise){

    var previewData = getPreviewPromise.data;
    $scope.previewDetails={
        scholarship:{},
        bioData:{},
        profquali:{},
        higherInst:{},
        basicQualifications:{}
    };
    for(var category in previewData)
    {
        for(var data in previewData[category])
        {
            //console.log(data +" => "+previewData[category][data]);
            $scope.previewDetails[category][data] = previewData[category][data];
        }
    }

    $scope.submitApplication=function()
    {
        ApplicationService.submit()


    }
})

tarapet.controller('ChangePasswordController',function($scope,AuthService){

    $scope.error=null
    $scope.showConfirmError=false;
    $scope.passwords={
        old:null,
        new:null,
        confirm:null
    }
    $scope.changePassword=function()
    {
        if($scope.passwords.new !== $scope.passwords.confirm)
        {

            $scope.error="Your new passwords do not match";
            $scope.showConfirmError=true;
        }
        else
            AuthService.changePassword($scope.passwords)
                .success(function(data){
            }).error(function(data){
                    $scope.error=data.message;
                    $scope.showConfirmError=true;
                });
    }
});

tarapet.controller('SignupConfController',function($scope,$location){
    $scope.loading=false;
    $scope.email=null;
    $scope.full_name=null;
})
tarapet.directive('bssbLoader', function()
{
    return {
        templateUrl:"../views/loader.html",
        restrict:"E",
        link:function(scope,element,attrib)
        {
            var el= angular.element(element)
            el.css("z-index",100000)
        }

    }
});

tarapet.directive('appProgress',function($rootScope, SessionService)
{

    return {
        templateUrl:"../views/app-progress.html",
        restrict:"E",
        controller:function($scope,$http,SessionService)
        {
            $scope.getAppData=function()
            {
                $http.get('main/getAppData',{
                    params:{
                        user_id:SessionService.get('user_id')
                    }
                }).success(function(data){
                        console.log("Suceess handler returned: "+data.app_progress)
                        $scope.appProgress = data.app_progress;
                        $rootScope.$$phase || $rootScope.$apply();
                    }).error(function(data){
                        console.log(data);
                    });
            }
        },
        link:function(scope,element,attribs,ctrl)
        {
            scope.getAppData();
            var el = angular.element(element)
            setTimeout(function(){
                el.find('.bar').css('width',scope.appProgress+"%");
                scope.$apply();
            },1000)
        }

    }
});

tarapet.directive('alert',function($rootScope){
    return{
        templateUrl:"../views/alert.html",
        restrict:"E",
        controller:function(){

        },
        link:function(scope,el,attrib,ctrl)
        {
            console.log(ctrl);
            console.log(scope)
            console.dir(attrib)

        }
    }
})

tarapet.filter('trimOffPath',function(){
    return function(fullPath)
    {
        var result="";
        var min_char_length = 10;
        if(fullPath){
            result = fullPath.substring(fullPath.lastIndexOf('\\')+1)
            if(result.length >= min_char_length)
                result = result.substring(result.lastIndexOf('.') - min_char_length);
            return "..."+result;
        }
        else
            return null
    }
})