var admin = angular.module('admin',['ui.router'])
    .config(
        function($provide,$stateProvider,$urlRouterProvider,$httpProvider){
        $urlRouterProvider.otherwise('dashboard');
        $stateProvider.state('dashboard',{
            url:'/dashboard',
            templateUrl:'/views/admin/admin-dashboard.html'
        });
});