<html ng-app="admin">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/bssb_admin.css"/>
    <link rel="stylesheet" type="text/css" href="../css/admin/css/bootstrap.min.css"/>
    <link href='http://fonts.googleapis.com/css?family=Duru+Sans|Open+Sans:300italic,400italic,400,600,700|Open+Sans+Condensed:300,300italic,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700|Droid+Sans:400,700|Duru+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/admin/style.css">
    <link href="../css/ui-grid-unstable.css" type="text/css" rel="stylesheet"/>
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
                <a ui-sref="applicants">
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
   Modal for Applicant details
-->
<div class="modal" id="applicantDetailsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 850px;">
        <div class="modal-content" style="background-color: #eee">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <strong><h4 class="modal-title" id="myModalLabel">Details for {{selectedApplicant[1].firstName}}</h4></strong>
            </div>
            <div class="modal-body" style="height: 556px;">
                <div class="detail-summary">
                    <img width="64" height="64" src="{{selectedApplicant[1].passportPhoto}}"/>
                </div>
                <!-- Nav tabs -->
                <ul id="applicantDetailsTab" class="nav nav-tabs">
                    <li class="active"><a href="#scholarship" data-toggle="tab">Scholarship</a></li>
                    <li><a href="#biodata" data-toggle="tab">Bio Data</a></li>
                    <li><a href="#basicQuali" data-toggle="tab">Basic Qualifications</a></li>
                    <li><a href="#higherInst" data-toggle="tab">Higher Institutions</a></li>
                    <li><a href="#profQuali" data-toggle="tab">Professional Qualifications</a></li>
                    <li><a href="#uploads" data-toggle="tab">Uploads</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div style="margin: 30px; overflow-y: auto;padding-right: 40px;height: 340px;" class="tab-pane active" id="scholarship">
                        <div class="detail-group">
                            <div class="detail-item">
                                <span class="detail-head">Type of Scholarship</span>
                                <span class="detail-content">{{selectedApplicant[0].scholarship_type}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Course of Study</span>
                                <span class="detail-content">{{selectedApplicant[0].course_of_study}}</span>
                            </div><div class="detail-item">
                                <span class="detail-head">Registration Number</span>
                                <span class="detail-content">{{selectedApplicant[0].reg_number}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Agreed to be bounded by Government?</span>
                                <span class="detail-content">{{selectedApplicant[0].government_bounded}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Has Admission?</span>
                                <span class="detail-content">{{selectedApplicant[0].has_admission}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Already in School?</span>
                                <span class="detail-content">{{selectedApplicant[0].already_in_school}}</span>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div style="margin: 30px; overflow-y: auto;padding-right: 40px;height: 340px;" class="tab-pane" id="biodata">
                        <h3>Personal Details</h3>
                        <div class="detail-group">
                            <div class="detail-item">
                                <span class="detail-head">First Name</span>
                                <span class="detail-content">{{selectedApplicant[1].firstName}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Middle Name</span>
                                <span class="detail-content">{{selectedApplicant[1].middleName}}</span>
                            </div><div class="detail-item">
                                <span class="detail-head">Surname</span>
                                <span class="detail-content">{{selectedApplicant[1].surname}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Date of Birth</span>
                                <span class="detail-content">{{selectedApplicant[1].dob}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Place of Birth</span>
                                <span class="detail-content">{{selectedApplicant[1].pob}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Gender</span>
                                <span class="detail-content">{{selectedApplicant[1].gender}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Phone Number</span>
                                <span class="detail-content">{{selectedApplicant[1].phone}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Email</span>
                                <span class="detail-content">{{selectedApplicant[1].email}}</span>
                            </div><div class="detail-item">
                                <span class="detail-head">Residential Address</span>
                                <span class="detail-content">{{selectedApplicant[1].residentialAddress}}</span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <h3>Mothers Details</h3>
                        <div class="detail-group">
                            <div class="detail-item">
                                <span class="detail-head">Mother's First Name</span>
                                <span class="detail-content">{{selectedApplicant[1].mFirstName}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Mother's Surname</span>
                                <span class="detail-content">{{selectedApplicant[1].mSurname}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Mother's Maiden Name</span>
                                <span class="detail-content">{{selectedApplicant[1].maidenName}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Mother's Village</span>
                                <span class="detail-content">{{selectedApplicant[1].mVillage}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Mother's Clan</span>
                                <span class="detail-content">{{selectedApplicant[1].mClan}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Mother's Local Govt Area</span>
                                <span class="detail-content">{{selectedApplicant[1].mLGA}}</span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <h3>Father's Details</h3>
                        <div class="detail-group">
                            <div class="detail-item">
                                <span class="detail-head">Father's First Name</span>
                                <span class="detail-content">{{selectedApplicant[1].pFirstName}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Father's Surname</span>
                                <span class="detail-content">{{selectedApplicant[1].pSurname}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Paternal Name</span>
                                <span class="detail-content">{{selectedApplicant[1].paternalName}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Father's Village</span>
                                <span class="detail-content">{{selectedApplicant[1].pVillage}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Father's Clan</span>
                                <span class="detail-content">{{selectedApplicant[1].pClan}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Father's Local Govt Area</span>
                                <span class="detail-content">{{selectedApplicant[1].pLGA}}</span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div style="margin: 30px; overflow-y: auto;padding-right: 40px;height: 340px;" class="tab-pane" id="basicQuali">
                        <h3>First Sitting Details</h3>
                        <div class="detail-group">
                            <div class="detail-item">
                                <span class="detail-head">Exam Name</span>
                                <span class="detail-content">{{selectedApplicant[2].s1_exam}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Center Name</span>
                                <span class="detail-content">{{selectedApplicant[2].s1_center_name}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Exam Number</span>
                                <span class="detail-content">{{selectedApplicant[2].s1_exam_number}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Exam Year</span>
                                <span class="detail-content">{{selectedApplicant[2].s1_exam_year}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Number of Credits</span>
                                <span class="detail-content">{{selectedApplicant[2].s1_credits}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Subjects and Grades</span>
                                <span class="detail-content">{{selectedApplicant[2].s1_subAndGrades}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Year Admitted</span>
                                <span class="detail-content">{{selectedApplicant[2].s1_year_admitted}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Year Graduated</span>
                                <span class="detail-content">{{selectedApplicant[2].s1_year_graduated}}</span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <h3>Second Sitting Details</h3>
                        <div class="detail-group">
                            <div class="detail-item">
                                <span class="detail-head">Exam Name</span>
                                <span class="detail-content">{{selectedApplicant[2].s2_exam}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Center Name</span>
                                <span class="detail-content">{{selectedApplicant[2].s2_center_name}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Exam Number</span>
                                <span class="detail-content">{{selectedApplicant[2].s2_exam_number}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Exam Year</span>
                                <span class="detail-content">{{selectedApplicant[2].s2_exam_year}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Number of Credits</span>
                                <span class="detail-content">{{selectedApplicant[2].s2_credits}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Subjects and Grades</span>
                                <span class="detail-content">{{selectedApplicant[2].s2_subAndGrades}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Year Admitted</span>
                                <span class="detail-content">{{selectedApplicant[2].s2_year_admitted}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Year Graduated</span>
                                <span class="detail-content">{{selectedApplicant[2].s2_year_graduated}}</span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <h3>A Levels Details</h3>
                        <div class="detail-group">
                            <div class="detail-item">
                                <span class="detail-head">Exam Name</span>
                                <span class="detail-content">{{selectedApplicant[2].a_exam}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Exam Center</span>
                                <span class="detail-content">{{selectedApplicant[2].a_center_name}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Exam Number</span>
                                <span class="detail-content">{{selectedApplicant[2].a_exam_number}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Number of Credits</span>
                                <span class="detail-content">{{selectedApplicant[2].a_credits}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Subjects and Grades</span>
                                <span class="detail-content">{{selectedApplicant[2].a_subAndGrades}}</span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <h3>Jamb Details</h3>
                        <div class="detail-group">
                            <div class="detail-item">
                                <span class="detail-head">Center Name</span>
                                <span class="detail-content">{{selectedApplicant[2].jamb_center_name}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Exam Number</span>
                                <span class="detail-content">{{selectedApplicant[2].jamb_exam_number}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Exam Year</span>
                                <span class="detail-content">{{selectedApplicant[2].jamb_exam_year}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Subjects and Scores</span>
                                <span class="detail-content">{{selectedApplicant[2].jamb_subAndScore}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Overall Score</span>
                                <span class="detail-content">{{selectedApplicant[2].jamb_total_score}}</span>
                            </div>
                        </div>
                    </div>
                    <div style="margin: 30px; overflow-y: auto;padding-right: 40px;height: 340px;" class="tab-pane" id="higherInst">
                        <div class="clearfix"></div>
                        <h3>First Institution</h3>
                        <div class="detail-group">
                            <div class="detail-item">
                                <span class="detail-head">University Name</span>
                                <span class="detail-content">{{selectedApplicant[3].inst1_name}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Admission Year</span>
                                <span class="detail-content">{{selectedApplicant[3].inst1_admission_year}}</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-head">Course of Study</span>
                                <span class="detail-content">{{selectedApplicant[3].inst1_cos}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Course Duration (in Years)</span>
                                <span class="detail-content">{{selectedApplicant[3].inst1_duration}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Final Grade</span>
                                <span class="detail-content">{{selectedApplicant[3].inst1_grade}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Expected Graduation Year</span>
                                <span class="detail-content">{{selectedApplicant[3].inst1_exp_grad_year}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Graduation Year</span>
                                <span class="detail-content">{{selectedApplicant[3].inst1_grad_year}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Reason for Extended Graduation year</span>
                                <span class="detail-content">{{selectedApplicant[3].inst1_reason}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Certificate Obtained</span>
                                <span class="detail-content">{{selectedApplicant[3].inst1_cert}}</span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <h3>Second Institution</h3>
                        <div class="detail-group">
                            <div class="detail-item">
                                <span class="detail-head">University Name</span>
                                <span class="detail-content">{{selectedApplicant[3].inst2_name}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Admission Year</span>
                                <span class="detail-content">{{selectedApplicant[3].inst2_admission_year}}</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-head">Course of Study</span>
                                <span class="detail-content">{{selectedApplicant[3].inst2_cos}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Course Duration (in Years)</span>
                                <span class="detail-content">{{selectedApplicant[3].inst2_duration}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Final Grade</span>
                                <span class="detail-content">{{selectedApplicant[3].inst2_grade}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Expected Graduation Year</span>
                                <span class="detail-content">{{selectedApplicant[3].inst2_exp_grad_year}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Graduation Year</span>
                                <span class="detail-content">{{selectedApplicant[3].inst2_grad_year}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Reason for Extended Graduation year</span>
                                <span class="detail-content">{{selectedApplicant[3].inst2_reason}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Certificate Obtained</span>
                                <span class="detail-content">{{selectedApplicant[3].inst2_cert}}</span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <h3>NYSC Details</h3>
                        <div class="detail-group">
                            <div class="detail-item">
                                <span class="detail-head">NYSC State</span>
                                <span class="detail-content">{{selectedApplicant[3].nysc_state}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Call Up Number</span>
                                <span class="detail-content">{{selectedApplicant[3].nysc_call_up}}</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-head">NYSC Batch</span>
                                <span class="detail-content">{{selectedApplicant[3].nysc_batch}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">NYSC Completion Year</span>
                                <span class="detail-content">{{selectedApplicant[3].nysc_completion_year}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">NYSC Year</span>
                                <span class="detail-content">{{selectedApplicant[3].nysc_year}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Candidate Exempted?</span>
                                <span class="detail-content">{{selectedApplicant[3].nysc_exempted}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Reason for Exemption</span>
                                <span class="detail-content">{{selectedApplicant[3].reason_exempted}}</span>
                            </div>
                        </div>
                    </div>
                    <div style="margin: 30px; overflow-y: auto;padding-right: 40px;height: 340px;" class="tab-pane" id="profQuali">
                        <div class="clearfix"></div>
                        <h3>Institution 1</h3>
                        <div class="detail-group">
                            <div class="detail-item">
                                <span class="detail-head">Institution Name</span>
                                <span class="detail-content">{{selectedApplicant[4].inst1_name}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">License Number</span>
                                <span class="detail-content">{{selectedApplicant[4].inst1_license}}</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-head">Year Attended</span>
                                <span class="detail-content">{{selectedApplicant[4].inst1_year}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Designation</span>
                                <span class="detail-content">{{selectedApplicant[4].inst1_designation}}</span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <h3>Institution 2 (Additional)</h3>
                        <div class="detail-group">
                            <div class="detail-item">
                                <span class="detail-head">Institution Name</span>
                                <span class="detail-content">{{selectedApplicant[4].inst2_name}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">License Number</span>
                                <span class="detail-content">{{selectedApplicant[4].inst2_license}}</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-head">Year Attended</span>
                                <span class="detail-content">{{selectedApplicant[4].inst2_year}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Designation</span>
                                <span class="detail-content">{{selectedApplicant[4].inst2_designation}}</span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <h3>Referees</h3>
                        <div class="detail-group">
                            <div class="detail-item">
                                <span class="detail-head">RefereeFull Name</span>
                                <span class="detail-content">{{selectedApplicant[4].ref_full_name}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Referee Occupation</span>
                                <span class="detail-content">{{selectedApplicant[4].ref_occupation}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Referee Home Address</span>
                                <span class="detail-content">{{selectedApplicant[4].ref_address}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Referee Email Address</span>
                                <span class="detail-content">{{selectedApplicant[4].ref_email}}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-head">Referee Phone Number</span>
                                <span class="detail-content">{{selectedApplicant[4].ref_phone_number}}</span>
                            </div>
                        </div>
                    </div>
                    <div style="margin: 30px; overflow-y: auto;padding-right: 40px;height: 340px;" class="tab-pane" id="uploads">
                        <div class="clearfix"></div>
                        <h3>Uploaded Documents</h3>
                        <div class="detail-group">
                            <ul class="doc-upload-list" style="list-style: none;margin:0px">
                                <li>
                                    <div>
                                        <img width="64" height="64" src="{{selectedApplicant[1].passportPhoto}}"/>
                                        <div style="float: right;text-align: right">
                                            <h4>Passport Photo</h4>
                                            <a href="{{selectedApplicant[1].passportPhoto}}" target="_blank">Click to View</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <img width="64" height="64" src="/img/msword_logo.png"/>
                                        <div style="float: right;text-align: right">
                                            <h4>Essay Document (.docx)</h4>
                                            <a href="{{selectedApplicant[0].essay_url}}" target="_blank">Click to Download</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <img width="64" height="64" src="{{selectedApplicant[2].s1_cert_url}}"/>
                                        <div style="float: right;text-align: right">
                                            <h4>First Sitting Certificate</h4>
                                            <a href="{{selectedApplicant[2].s1_cert_url}}" target="_blank">Click to View</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <img width="64" height="64" src="{{selectedApplicant[2].s2_cert_url}}"/>
                                        <div style="float: right;text-align: right">
                                            <h4>Second Sitting Certificate</h4>
                                            <a href="{{selectedApplicant[2].s2_cert_url}}" target="_blank">Click to View</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <img width="64" height="64" src="{{selectedApplicant[2].a_cert_url}}"/>
                                        <div style="float: right;text-align: right">
                                            <h4>A Level Certificate</h4>
                                            <a href="{{selectedApplicant[2].a_cert_url}}" target="_blank">Click to View</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <img width="64" height="64" src="{{selectedApplicant[3].inst1_cert_url}}"/>
                                        <div style="float: right;text-align: right">
                                            <h4>Higher Institution 1 Certificate</h4>
                                            <a href="{{selectedApplicant[3].inst1_cert_url}}" target="_blank">Click to View</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <img width="64" height="64" src="{{selectedApplicant[3].inst2_cert_url}}"/>
                                        <div style="float: right;text-align: right">
                                            <h4>Higher Institution 2 Certificate</h4>
                                            <a href="{{selectedApplicant[3].inst2_cert_url}}" target="_blank">Click to View</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <img width="64" height="64" src="{{selectedApplicant[3].nysc_cert}}"/>
                                        <div style="float: right;text-align: right">
                                            <h4>NYSC Certificate</h4>
                                            <a href="{{selectedApplicant[3].nysc_cert}}" target="_blank">Click to View</a>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
            <form class="form" style="width: 360px;margin: auto">
            <div class="modal-body">
                    <div class="form-group">
                        <label>First name</label>
                        <input class="form-control" required type="text" ng-model="userModel.firstname" placeholder="Enter First Name"/>
                    </div>
                    <div class="form-group">
                        <label>Last name</label>
                        <input class="form-control" required type="text" ng-model="userModel.lastname" placeholder="Enter Last Name"/>
                    </div>
                    <div class="form-group">
                        <label>User Type</label>
                        <select required="" class="form-control" ng-model="userModel.userType" ng-options="uType.value for uType in userTypeList">
                            <option value="">--- Select Admin type----</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input id="email" class="form-control" autocomplete="false" ng-keyup="onConfirm($event)" type="text" pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$" ng-model="userModel.email" placeholder="Retype email address"/>
                    </div>
                    <div class="form-group">
                        <label>Retype Email Address</label>
                        <input id="conf_email" class="form-control" autocomplete="false" ng-keyup="onConfirm($event)" pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$" type="text" ng-model="userModel.conf_email" placeholder="Retype email address"/>
                        <p ng-show="showEmailMatchError" class="error-text">Email Addresses do not match</p>
                        {{userModel.email !== userModel.conf_email}}
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label>Password</label>
                        <input id="password" class="form-control" ng-keyup="onConfirm($event)" required type="password" ng-model="userModel.password" placeholder="Retype email address"/>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input id="conf_password" class="form-control" ng-keyup="onConfirm($event)" required type="password" ng-model="userModel.conf_password" placeholder="Retype email address"/>
                        <p ng-show="showPasswordMatchError" class="error-text">Passwords do not match</p>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" ng-click="createUser()" data-dismiss="modal" class="btn btn-primary">Create User</button>
            </div>
            </form>
        </div>
</div>

<script src="/js/ext/jquery.js"></script>
<script src="/js/admin/js/bootstrap.js"></script>
<script src="/js/ext/angular-1-2-0.js"></script>
<script src="/js/ext/angular-cookies.js"></script>
<script src="/js/ext/angular-ui-router.js"></script>
<script src="/js/ext/ui-grid-unstable.js"></script>
<script src="/js/admin.js"></script>
<script>
    $('.view-control').tooltip({
        placement:'bottom'
    });

    $('#applicantDetailsTab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })

</script>
</body>
</html>