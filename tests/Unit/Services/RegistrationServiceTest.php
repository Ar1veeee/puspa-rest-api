<?php

namespace Tests\Unit\Services;

use App\Http\Repositories\ChildRepository;
use App\Http\Repositories\FamilyRepository;
use App\Http\Repositories\GuardianRepository;
use App\Http\Repositories\ObservationRepository;
use App\Http\Repositories\UserRepository;
use App\Models\Child;
use App\Models\Family;
use App\Models\Guardian;
use App\Models\Observation;
use App\Models\User;
use App\Services\RegistrationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class RegistrationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected RegistrationService $registrationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->registrationService = new RegistrationService(
            new UserRepository(new User()),
            new FamilyRepository(new Family()),
            new GuardianRepository(new Guardian()),
            new ChildRepository(new Child()),
            new ObservationRepository(new Observation())
        );
    }

    /**
     * @test
     * Testing registration success with valid data.
     */
    public function registrationShouldSucceedWithValidData(): void
    {
        $data = [
            'email' => 'wali.baru@example.com',
            'guardian_name' => 'Budi Santoso',
            'guardian_phone' => '081234567890',
            'guardian_type' => 'Ayah',
            'child_name' => 'Citra Lestari',
            'child_gender' => 'Perempuan',
            'child_birth_place' => 'Jakarta',
            'child_birth_date' => now()->subYears(7)->format('Y-m-d'),
            'child_school' => 'SDN 1 Pagi',
            'child_address' => 'Jl. Merdeka No. 10',
            'child_complaint' => 'Sulit berkonsentrasi',
            'child_service_choice' => 'Terapi Okupasi',
        ];

        $this->registrationService->registration($data);

        $this->assertDatabaseCount('families', 1);
        $this->assertDatabaseHas('guardians', [
            'temp_email' => 'wali.baru@example.com',
            'guardian_name' => 'Budi Santoso',
        ]);
        $this->assertDatabaseHas('children', [
            'child_name' => 'Citra Lestari',
        ]);
        $this->assertDatabaseCount('observations', 1);
        $this->assertDatabaseHas('observations', [
            'age_category' => 'Anak-anak',
            'status' => 'pending',
        ]);
    }

    /**
     * @test
     * Testing registration failed when email already used.
     */
    public function registrationShouldThrowValidationExceptionForExistingEmail(): void
    {
        $this->expectException(ValidationException::class);

        User::factory()->create(['email' => 'sudah.ada@example.com']);

        $data = [
            'email' => 'sudah.ada@example.com',
            'guardian_name' => 'Budi Santoso',
            'guardian_phone' => '081234567890',
            'guardian_type' => 'Ayah',
            'child_name' => 'Citra Lestari',
            'child_gender' => 'Perempuan',
            'child_birth_place' => 'Jakarta',
            'child_birth_date' => now()->subYears(7)->format('Y-m-d'),
            'child_school' => 'SDN 1 Pagi',
            'child_address' => 'Jl. Merdeka No. 10',
            'child_complaint' => 'Sulit berkonsentrasi',
            'child_service_choice' => 'Terapi Okupasi',
        ];

        $this->registrationService->registration($data);

        $this->assertDatabaseCount('families', 0);
        $this->assertDatabaseCount('guardians', 0);
        $this->assertDatabaseCount('children', 0);
    }
}
