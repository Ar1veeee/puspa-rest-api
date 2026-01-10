<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\OwnerService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class OwnerServiceTest extends TestCase
{
    use RefreshDatabase;

    private OwnerService $ownerService;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat semua role dengan guard 'api'
        Role::create(['name' => 'admin', 'guard_name' => 'api']);
        Role::create(['name' => 'terapis', 'guard_name' => 'api']);
        Role::create(['name' => 'asesor', 'guard_name' => 'api']);

        $this->ownerService = new OwnerService();
    }

    /** @test */
    public function get_all_admin_unverified_returns_only_unverified_admins()
    {
        User::factory()->create(['is_active' => true]);

        $unverifiedAdmin1 = User::factory()->create(['is_active' => false]);
        $unverifiedAdmin2 = User::factory()->create(['is_active' => false]);
        $unverifiedAdmin1->assignRole('admin');
        $unverifiedAdmin2->assignRole('admin');

        $verifiedAdmin = User::factory()->create(['is_active' => true]);
        $verifiedAdmin->assignRole('admin');

        $result = $this->ownerService->getAllAdminUnverified();

        $this->assertCount(2, $result);
        $this->assertTrue($result->contains($unverifiedAdmin1));
        $this->assertTrue($result->contains($unverifiedAdmin2));
        $this->assertFalse($result->contains($verifiedAdmin));
    }

    /** @test */
    public function get_all_therapist_unverified_returns_only_unverified_therapists()
    {
        $unverifiedTherapist1 = User::factory()->create(['is_active' => false]);
        $unverifiedTherapist2 = User::factory()->create(['is_active' => false]);
        $unverifiedTherapist1->assignRole('terapis');
        $unverifiedTherapist2->assignRole('terapis');

        $verifiedTherapist = User::factory()->create(['is_active' => true]);
        $verifiedTherapist->assignRole('terapis');

        $result = $this->ownerService->getAllTherapistUnverified();

        $this->assertCount(2, $result);
        $this->assertTrue($result->contains($unverifiedTherapist1));
        $this->assertTrue($result->contains($unverifiedTherapist2));
        $this->assertFalse($result->contains($verifiedTherapist));
    }

    /** @test */
    public function promote_to_assessor_syncs_asesor_role_and_removes_previous_roles()
    {
        $user = User::factory()->create();
        $user->assignRole('terapis');

        $promotedUser = $this->ownerService->promoteToAssessor($user->fresh());

        $this->assertTrue($promotedUser->hasRole('asesor'));
        $this->assertFalse($promotedUser->hasRole('terapis')); // syncRoles ganti semua
    }

    /** @test */
    public function activate_account_sets_is_active_and_email_verified_at()
    {
        // Bypass mass assignment protection
        $user = User::factory()->create();
        DB::table('users')->where('id', $user->id)->update([
            'is_active' => false,
            'email_verified_at' => null,
        ]);
        $user->refresh();

        $activatedUser = $this->ownerService->activateAccount($user);

        $refreshedUser = $activatedUser->fresh();

        $this->assertTrue((bool) $refreshedUser->is_active);
        $this->assertNotNull($refreshedUser->email_verified_at);

        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $refreshedUser->email_verified_at);

        $this->assertTrue(DB::table('users')->where('id', $user->id)->where('is_active', true)->exists());
    }

    /** @test */
    public function activate_account_runs_inside_transaction()
    {
        $user = User::factory()->create(['is_active' => false]);

        DB::spy();
        DB::shouldReceive('transaction')->once()->andReturnUsing(fn($callback) => $callback());

        $this->ownerService->activateAccount($user);
    }

    /** @test */
    public function delete_account_deletes_user_inside_transaction()
    {
        $user = User::factory()->create();

        DB::shouldReceive('transaction')
            ->once()
            ->andReturnUsing(function ($callback) {
                return $callback();
            });

        $this->ownerService->deleteAccount($user);

        $this->assertNull(User::find($user->id));
    }
}
