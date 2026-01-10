<?php

namespace Tests\Unit\Services;

use App\Actions\Guardian\AddChildAction;
use App\Actions\Guardian\UpdateFamilyGuardiansAction;
use App\Models\Child;
use App\Models\Guardian;
use App\Models\User;
use App\Services\GuardianService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class GuardianServiceTest extends TestCase
{
    use RefreshDatabase;

    private GuardianService $guardianService;

    /** @var AddChildAction|MockInterface */
    private $addChildActionMock;

    /** @var UpdateFamilyGuardiansAction|MockInterface */
    private $updateFamilyGuardiansActionMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock kedua Action
        $this->addChildActionMock = Mockery::mock(AddChildAction::class);
        $this->updateFamilyGuardiansActionMock = Mockery::mock(UpdateFamilyGuardiansAction::class);

        // Inject mock ke service
        $this->guardianService = new GuardianService(
            $this->addChildActionMock,
            $this->updateFamilyGuardiansActionMock
        );
    }

    /** @test */
    public function get_profile_returns_guardian_with_loaded_user_relation()
    {
        $user = User::factory()->create(['email' => 'guardian@example.com']);
        $guardian = Guardian::factory()->create(['user_id' => $user->id]);

        $result = $this->guardianService->getProfile($user->id);

        $this->assertInstanceOf(Guardian::class, $result);
        $this->assertTrue($result->relationLoaded('user'));
        $this->assertEquals($user->id, $result->user->id);
        $this->assertEquals('guardian@example.com', $result->user->email);
    }

    /** @test */
    public function add_child_calls_add_child_action_and_returns_child()
    {
        $guardian = Guardian::factory()->create();
        $data = [
            'child_name' => 'Budi',
            'child_birth_date' => '2018-05-10',
        ];

        $expectedChild = Child::factory()->make();

        $this->addChildActionMock
            ->shouldReceive('execute')
            ->once()
            ->with($guardian, $data)
            ->andReturn($expectedChild);

        $result = $this->guardianService->addChild($guardian, $data);

        $this->assertSame($expectedChild, $result);
    }

    /** @test */
    public function update_family_guardians_calls_action_with_correct_parameters()
    {
        $primaryGuardian = Guardian::factory()->create();
        $data = ['secondary_guardian_name' => 'Ibu Budi'];

        $this->updateFamilyGuardiansActionMock
            ->shouldReceive('execute')
            ->once()
            ->with($primaryGuardian, $data);

        $this->guardianService->updateFamilyGuardians($primaryGuardian, $data);

        // Assertion otomatis dari Mockery (akan gagal jika tidak dipanggil sesuai ekspektasi)
        $this->assertTrue(true);
    }

    /** @test */
    public function update_profile_updates_user_email_and_guardian_fields_then_returns_fresh_guardian_with_user()
    {
        // Buat user dan guardian dengan data yang PASTI valid
        $user = User::factory()->create([
            'email' => 'old@example.com',
        ]);

        $guardian = Guardian::factory()->create([
            'user_id'         => $user->id,
            'guardian_name'   => 'Old Name',
            'guardian_phone'  => '08123456789', // plain text → Laravel encrypt otomatis jika dicast
            'guardian_type'   => 'ayah',       // PASTIKAN nilai ini ADA di enum migration!
        ]);

        // Data update - gunakan nilai yang berbeda agar perubahan terlihat
        $data = [
            'email'          => 'new@example.com',
            'guardian_name'  => 'New Name',
            'guardian_phone' => '08987654321',
            'guardian_type'  => 'ibu',       // Ganti ke nilai lain yang VALID di enum
            // Jangan masukkan field lain yang tidak ada di fillable atau cause error
        ];

        $updatedGuardian = $this->guardianService->updateProfile($guardian, $data);

        // Refresh dari database
        $freshGuardian = $updatedGuardian->fresh();
        $freshUser = $freshGuardian->user->fresh();

        // Assertions
        $this->assertEquals('new@example.com', $freshUser->email);

        $this->assertEquals('New Name', $freshGuardian->guardian_name);
        $this->assertEquals('08987654321', $freshGuardian->guardian_phone); // decrypted otomatis
        $this->assertEquals('ibu', $freshGuardian->guardian_type);

        $this->assertTrue($freshGuardian->relationLoaded('user'));
    }
}
