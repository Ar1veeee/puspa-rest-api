<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User Management
        Permission::create(['name' => 'show_unverified_admins']);
        Permission::create(['name' => 'show_unverified_therapists']);
        Permission::create(['name' => 'verified_user']);
        Permission::create(['name' => 'rejected_user']);
        Permission::create(['name' => 'show_admins']);
        Permission::create(['name' => 'show_detail_admin']);
        Permission::create(['name' => 'add_admin']);
        Permission::create(['name' => 'edit_admin']);
        Permission::create(['name' => 'delete_admin']);
        Permission::create(['name' => 'show_therapists']);
        Permission::create(['name' => 'show_detail_therapist']);
        Permission::create(['name' => 'add_therapist']);
        Permission::create(['name' => 'edit_therapist']);
        Permission::create(['name' => 'delete_therapist']);
        Permission::create(['name' => 'show_children']);
        Permission::create(['name' => 'show_detail_child']);
        Permission::create(['name' => 'edit_child']);
        Permission::create(['name' => 'delete_child']);

        // Observation Management
        Permission::create(['name' => 'show_observations']);
        Permission::create(['name' => 'show_detail_observation']);
        Permission::create(['name' => 'edit_schedule_observation']);
        Permission::create(['name' => 'submit_observation']);
        Permission::create(['name' => 'show_observation_answer']);
        Permission::create(['name' => 'show_observation_summary']);
        Permission::create(['name' => 'set_assessment']);

        // Assessment Management
        Permission::create(['name' => 'show_assessments']);
        Permission::create(['name' => 'show_detail_assessment']);
        Permission::create(['name' => 'show_own_children_assessment']);
        Permission::create(['name' => 'show_own_child_detail_assessment']);
        Permission::create(['name' => 'show_assessor_assessment_answer']);
        Permission::create(['name' => 'show_parent_assessment_answer']);
        Permission::create(['name' => 'edit_schedule_assessment']);
        Permission::create(['name' => 'submit_assessment']);
        Permission::create(['name' => 'submit_parent_assessment']);
        Permission::create(['name' => 'upload_report_assessment_file']);
        Permission::create(['name' => 'download_child_report_assessment_file']);

        $owner = Role::create(['name' => 'owner']);
        $owner->givePermissionTo([
            'show_admins',
            'show_detail_admin',
            'show_therapists',
            'show_detail_therapist',
            'show_children',
            'show_detail_child',
        ]);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(
            [
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
                'show_observations',
                'show_detail_observation',
                'edit_schedule_observation',
                'show_observation_answer',
                'show_observation_summary',
                'set_assessment',
                'show_assessments',
                'show_detail_assessment',
                'show_assessor_assessment_answer',
                'show_parent_assessment_answer',
                'edit_schedule_assessment',
                'upload_report_assessment_file',
            ]
        );

        $assessor = Role::create(['name' => 'asesor']);
        $assessor->givePermissionTo([
            'show_observations',
            'show_detail_observation',
            'submit_observation',
            'show_observation_answer',
            'show_observation_summary',
            'show_assessments',
            'show_detail_assessment',
            'show_parent_assessment_answer',
            'show_assessor_assessment_answer',
            'submit_assessment',
            'upload_report_assessment_file',
        ]);

        $therapist = Role::create(['name' => 'terapis']);
        $therapist->givePermissionTo([
            'show_observations',
            'show_detail_observation',
            'submit_observation',
            'show_observation_answer',
            'show_observation_summary',
        ]);

        $parent = Role::create(['name' => 'user']);
        $parent->givePermissionTo([
            'show_own_children_assessment',
            'edit_child',
            'delete_child',
            'show_own_child_detail_assessment',
            'show_parent_assessment_answer',
            'submit_parent_assessment',
            'download_child_report_assessment_file',
        ]);
    }
}
