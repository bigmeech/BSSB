/**
 * Created by laggie on 13/11/13.
 */
var demoApp = angular.module('demoApp', []);

demoApp.factory('simpleFactory', function(){

    var customers = [{name:'John Smith', city: 'Los Angeles'},
        {name:'Kolade Kehinde', city: 'Lagos'},
        {name:'John Odukwe', city : 'Owerri'},
        {name:'Jane Doe', city: 'Newyork'}];

    return{
        getCustomers:function(){
            return customers;
        }
    }
});

demoApp.config(function($routeProvider){
    $routeProvider
        .when('/',
        {
            controller : 'SimpleController',
            templateUrl : 'Partials/View1.html'

        })
        .when('/View2',
        {
            controller : 'SimpleController',
            templateUrl : 'Partials/View2.html'

        })
        .otherwise({ redirectTo: '/' });

});

/////SimpleController///////////////////////////////////////
function SimpleController($scope, simpleFactory){

    $scope.customers =  [];

    init();

    function init(){
        $scope.customers = simpleFactory.getCustomers();
    }

    $scope.addCustomer = function(){

        $scope.customers.push({
            name : $scope.newCustomer.name,
            city: $scope.newCustomer.city
        })

    }

}

demoApp.controller('SimpleController', SimpleController);