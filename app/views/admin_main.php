<html ng-app="admin">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/bssb_admin.css"/>
    <link rel="stylesheet" type="text/css" href="../css/admin/css/bootstrap.min.css"/>
    <link href='http://fonts.googleapis.com/css?family=Duru+Sans|Open+Sans:300italic,400italic,400,600,700|Open+Sans+Condensed:300,300italic,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700|Droid+Sans:400,700|Duru+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://i.icomoon.io/public/temp/bc550e0868/UntitledProject1/style.css">
    <link href="/css/ng-grid.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<div id="main-content">
    <div id="main-nav">
        <img width="180" style="margin: 30px" height="50"  src="/img/logo.png" w/>
        <ul class="nav-menu">
            <li>
                <a ui-sref="dashboard">
                    <span class="icon-home"></span>&nbsp;Dashboard
                </a>
            </li>
            <li>
                <a ui-sref="users">
                    <span class="icon-users"></span>&nbsp;Registered Users
                </a>
            </li>
            <li>
                <a ui-sref="dashboard">
                    <span class="icon-user"></span>&nbsp;Applicants
                </a>
            </li>
            <li>
                <a ui-sref="dashboard">
                    <span class="icon-eye"></span>&nbsp;Under Review
                </a>
            </li>
            <li>
                <a ui-sref="dashboard">
                    <span class="icon-thumbs-up"></span>&nbsp;Approved
                </a>
            </li>
            <li><a ui-sref="dashboard">
                    <span class="icon-thumbs-up2"></span>&nbsp;Declined
                </a>
            </li>
            <li>
                <a ui-sref="dashboard">
                    <span class="icon-cog"></span>&nbsp;Settings
                </a>
            </li>
            <li style="border-top: 1px dashed #999;color: #005580">
                <a ui-sref="dashboard">
                    <span class="icon-exit"></span>&nbsp;Log out
                </a>
            </li>
        </ul>
    </div>
    <div id="content-area">
        <div ui-view>

        </div>
    </div>
</div>

<!--
    modal for send notification
-->
<div class="modal" id="sendNotificationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #eee">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Send out Notifications</h4>
            </div>
            <div class="modal-body">
                <textarea class="form-control" rows="7"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send Now</button>
            </div>
        </div>
    </div>
</div>

<!--
   Modal for Delete User confirmation
-->
<div class="modal" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #eee">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <strong><h5 class="modal-title" id="myModalLabel">Delete User?</h5></strong>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <p><strong>WARNING!</strong> The user will never be able to log in again to complete his application and will have to register again. All associated scholarship data will be deleted as well.</p>
                </div>
                <p>Are you sure you want to delete <strong>"{{selectedUser.firstname}} {{selectedUser.lastname}}"</strong>.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" data-dismiss="modal" ng-click="deleteUser()" class="btn btn-primary">Yes, Delete!</button>
            </div>
        </div>
    </div>
</div>

<!--
    modal for Add User Form
-->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #eee">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add New User</h4>
            </div>
            <div class="modal-body">
                <form class="form" style="width: 360px;margin: auto">
                    <div class="form-group">
                        <label>First name</label>
                        <input class="form-control" required type="text" ng-model="credentials.firstname" placeholder="Enter First Name"/>
                    </div>
                    <div class="form-group">
                        <label>Last name</label>
                        <input class="form-control" required type="text" ng-model="credentials.lastname" placeholder="Enter Last Name"/>
                    </div>
                    <div class="form-group">
                        <label>User Type</label>
                        <select required="" class="form-control" ng-model="userType" ng-options="uType.value for uType in userTypeList">
                            <option value="">--- Select Admin type----</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input class="form-control" required type="email" ng-model="credentials.retype_email" placeholder="Retype email address"/>
                    </div>
                    <div class="form-group">
                        <label>Retype Email Address</label>
                        <input class="form-control" required type="email" ng-model="credentials.retype_email" placeholder="Retype email address"/>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" required type="password" ng-model="credentials.retype_email" placeholder="Retype email address"/>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input class="form-control" required type="password" ng-model="credentials.retype_email" placeholder="Retype email address"/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Create User</button>
            </div>
        </div>
</div>

<script src="/js/ext/jquery.js"></script>
<script src="/js/admin/js/bootstrap.js"></script>
<script src="/js/ext/angular-1-2-0.js"></script>
<script src="/js/ext/angular-cookies.js"></script>
<script src="/js/ext/angular-ui-router.js"></script>

<script src="/js/ext/ng-grid.js"></script>
<script src="/js/admin.js"></script>
<script>
    $('.view-control').tooltip({
        placement:'bottom'
    });
</script>
</body>
</html>