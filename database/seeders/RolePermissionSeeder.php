<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $corePermissions = [
            'dashboard.view',
            'reports.view',
            'analytics.view',
            'docs.view',
        ];

        $resources = [
            'students',
            'courses',
            'sections',
            'assessments',
            'grades',
            'attendance',
            'kpis',
        ];

        $resourceActions = ['viewAny', 'view', 'create', 'update', 'delete'];

        $resourcePermissions = [];
        foreach ($resources as $resource) {
            foreach ($resourceActions as $action) {
                $resourcePermissions[] = "{$resource}.{$action}";
            }
        }

        $permissions = array_merge($corePermissions, $resourcePermissions);

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $instructor = Role::firstOrCreate(['name' => 'Instructor']);
        $student = Role::firstOrCreate(['name' => 'Student']);
        $quality = Role::firstOrCreate(['name' => 'QualityOfficer']);

        $grant = function (string $resource, ?array $actions = null) use ($resourceActions): array {
            $actions ??= $resourceActions;

            return array_map(static fn ($action) => "{$resource}.{$action}", $actions);
        };

        $admin->syncPermissions($permissions);
        $instructor->syncPermissions(array_merge(
            $corePermissions,
            $grant('courses'),
            $grant('sections'),
            $grant('assessments'),
            $grant('grades'),
            $grant('attendance')
        ));
        $student->syncPermissions($corePermissions);
        $quality->syncPermissions(array_merge(
            $corePermissions,
            $grant('kpis'),
            $grant('courses', ['viewAny', 'view']),
            $grant('sections', ['viewAny', 'view'])
        ));
    }
}
