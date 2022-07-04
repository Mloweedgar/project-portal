<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Role management Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'add' => 'Add user',
    'edit_project_coordinator' => 'Add / Edit Data Entries Generic',

    'edit-users-title' => 'Add / Edit Users',
    'name' => 'Name',
    'email' => 'Email',
    'entity' => 'Entity',
    'sectors' => 'Sectors',
    'sections' => 'Sections',
    'projects' => 'Projects',
    'role' => 'Role',
    'telephone' => 'Telephone',
    'date' => 'Date added',
    'inactive' => 'Inactive',
    'choose-option' => 'Choose an option',
    'oops' => 'Oops!',
    'msg_no_role_selected' => 'You have to select a role before assign permissions.',
    'mail_error' => "The email couldn't be sent",
    'save_confirm' => "Please, confirm if you want to create the new user",
    'success' => "The user has been successfully saved. An email with the user password has been sent to the registered email.",
    'updated' => "The user has been successfully updated",
    "update_confirm" => "Please, confirm if you want to update the selected user",


    //Permissions
    'permissions' => 'Permissions',
    'select-permissions' => "Please assign user permissions. At least one section and a project are required.",
    'projects_required' => "Please select at least one project in order to continue.",
    'sectors_required' => "Please select at least one sector in order to continue.",
    'select_permissions_save' => "Please assign permissions before creating the user.",
    'select-all' => 'Select all',
    'save' => 'Save changes',
    'back' => 'Go back',

    //Project coordinator
    //
    'project-coordinator' => 'Project coordinator',
    'project-coordinator-title' => 'Assign a Project Coordinator',
    'project-coordinator-details' => "Please, in order to register a data entry, you must assign a project coordinator. Keep in mind that the permissions that the project coordinator has, will be assigned to the new data entry user.",
    'select_project_coordinator' => "Please, assign a project coordinator.",
    'next' => 'Next',
    'cancel' => 'Cancel',
    'edit_permission_project_coordinator' => "Edit Generic Data Entry Permissions",

    // Password change

    'change-password' => 'Change your login password',
    'old-password' => 'Current password',
    'new-password' => 'New password',
    'new-password-confirm' => 'Confirm your new password',
    'old-password-placeholder' => 'Type here your current password',
    'new-password-placeholder' => 'Type here your new password',
    'new-password-confirm-placeholder' => 'Type here again your new password',
    'password-change-success' => 'The password has been successfully changed',
    'password-change-mismatch' => 'The current password provided does not match your password',
    'password-change-insecure' => 'The new password does not meet complexity requirements',

    //Delete
    'delete_description' => "Please add a comment explaining the reasons behind the deletion of the selected user.",
    'delete_title' => "Delete the selected user",
    'delete_description_placeholder' => "Add a comment",
    'delete_all' => "Delete the information related to this user",
    'delete_assign' => "Assign the information to a specific user",
    'delete_user' => "Delete user",
    'delete_confirm_all' => "Please, confirm if you want to delete the selected user. All the information related to the user will be deleted and it can't be recovered.",
    'delete_confirm_assign' => "Please, confirm if you want to delete the selected user. All the information will be assigned to the previous selected user.",
    'deleted' => "The user has been successfully deleted.",

    //Email

    'account_registered' => "Account registered",

    //Inactive
    'inactivate_confirm' => "Please, confirm if you want to inactivate the selected user",
    'activated' => 'User is now active',
    'active_new_pass' => 'Please, notify the user. A new secure password has been generated: ',

    'choose_projects' => 'Assign projects',

    //Deleted users
    'deleted_date' => 'Deleted date',

];
