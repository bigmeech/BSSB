var PrepApp = angular.module('PrepApp', []);

PrepApp.config(function($routeProvider){
    $routeProvider
        .when('/',
        {
            controller : 'SimpleController',
            templateUrl : 'partials/home.html'

        })
        .when('/category',
        {
            controller : 'categoryController',
            templateUrl : 'partials/category.html'

        })
    //.otherwise({ redirectTo: '/' });

});



/////categoryController///////////////////////////////////////
function categoryController($scope, mainFactory, $location){

    //init();
    console.log($location.path());

    $scope.fireSomething = function(){
        debugger;
    }

}

/////SimpleController///////////////////////////////////////
function SimpleController($scope, mainFactory, $location){

    $scope.category =  [];

    init();

    function init(){
        $scope.category = mainFactory.getCategories();
    }

    $scope.loadCategory = function(cat){

        var category = cat;
        $location.path("/category");

        console.log($location.path());

    }

}

PrepApp.controller('SimpleController', SimpleController);
PrepApp.controller('categoryController', categoryController);

////////////////////////mainFactory////////////////////////////////////////////////
PrepApp.factory('mainFactory', function(){

    var category = [{name:'GMAT', city: 'Los Angeles'},
        {name:'Apptitude', city: 'Lagos'},
        {name:'O Levels', city : 'Owerri'},
        {name:'ICAN', city: 'Newyork'}];

    var factory = {};

    factory.getCategories = function(){
        return category;
    }

    return factory;
});/**
 * Created by laggie on 29/11/13.
 */
