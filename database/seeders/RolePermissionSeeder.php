<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // User Management
            'show_unverified_admins',
            'show_unverified_therapists',
            'verified_user',
            'rejected_user',
            'show_admins',
            'show_detail_admin',
            'add_admin',
            'edit_admin',
            'delete_admin',
            'show_therapists',
            'show_detail_therapist',
            'add_therapist',
            'edit_therapist',
            'delete_therapist',
            'show_children',
            'show_detail_child',
            'edit_child',
            'delete_child',

            // Observation Management
            'show_observations',
            'show_detail_observation',
            'edit_schedule_observation',
            'submit_observation',
            'show_observation_answer',
            'show_observation_summary',
            'set_assessment',

            // Assessment Management
            'show_assessments',
            'show_detail_assessment',
            'show_own_children_assessment',
            'show_own_child_detail_assessment',
            'show_assessor_assessment_answer',
            'show_parent_assessment_answer',
            'edit_schedule_assessment',
            'submit_assessment',
            'submit_parent_assessment',
            'upload_report_assessment_file',
            'download_child_report_assessment_file',
        ];

        $createdPermissions = [];
        foreach ($permissions as $permission) {
            $createdPermissions[$permission] = Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'api']
            );
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $owner = Role::firstOrCreate(['name' => 'owner', 'guard_name' => 'api']);
        $owner->syncPermissions([
            $createdPermissions['show_admins'],
            $createdPermissions['show_detail_admin'],
            $createdPermissions['show_therapists'],
            $createdPermissions['show_detail_therapist'],
            $createdPermissions['show_children'],
            $createdPermissions['show_detail_child'],
        ]);

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);
        $admin->syncPermissions([
            $createdPermissions['show_admins'],
            $createdPermissions['show_detail_admin'],
            $createdPermissions['add_admin'],
            $createdPermissions['edit_admin'],
            $createdPermissions['delete_admin'],
            $createdPermissions['show_therapists'],
            $createdPermissions['show_detail_therapist'],
            $createdPermissions['add_therapist'],
            $createdPermissions['edit_therapist'],
            $createdPermissions['delete_therapist'],
            $createdPermissions['show_children'],
            $createdPermissions['show_detail_child'],
            $createdPermissions['edit_child'],
            $createdPermissions['delete_child'],
            $createdPermissions['show_observations'],
            $createdPermissions['show_detail_observation'],
            $createdPermissions['edit_schedule_observation'],
            $createdPermissions['show_observation_answer'],
            $createdPermissions['show_observation_summary'],
            $createdPermissions['set_assessment'],
            $createdPermissions['show_assessments'],
            $createdPermissions['show_detail_assessment'],
            $createdPermissions['show_assessor_assessment_answer'],
            $createdPermissions['show_parent_assessment_answer'],
            $createdPermissions['edit_schedule_assessment'],
            $createdPermissions['upload_report_assessment_file'],
        ]);

        $assessor = Role::firstOrCreate(['name' => 'asesor', 'guard_name' => 'api']);
        $assessor->syncPermissions([
            $createdPermissions['show_observations'],
            $createdPermissions['show_detail_observation'],
            $createdPermissions['submit_observation'],
            $createdPermissions['show_observation_answer'],
            $createdPermissions['show_observation_summary'],
            $createdPermissions['show_assessments'],
            $createdPermissions['show_detail_assessment'],
            $createdPermissions['show_parent_assessment_answer'],
            $createdPermissions['show_assessor_assessment_answer'],
            $createdPermissions['submit_assessment'],
            $createdPermissions['upload_report_assessment_file'],
        ]);

        $therapist = Role::firstOrCreate(['name' => 'terapis', 'guard_name' => 'api']);
        $therapist->syncPermissions([
            $createdPermissions['show_observations'],
            $createdPermissions['show_detail_observation'],
            $createdPermissions['submit_observation'],
            $createdPermissions['show_observation_answer'],
            $createdPermissions['show_observation_summary'],
        ]);

        $parent = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'api']);
        $parent->syncPermissions([
            $createdPermissions['show_own_children_assessment'],
            $createdPermissions['edit_child'],
            $createdPermissions['delete_child'],
            $createdPermissions['show_own_child_detail_assessment'],
            $createdPermissions['show_parent_assessment_answer'],
            $createdPermissions['submit_parent_assessment'],
            $createdPermissions['download_child_report_assessment_file'],
        ]);
    }
}