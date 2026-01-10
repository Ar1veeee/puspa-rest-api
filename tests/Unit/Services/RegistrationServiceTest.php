<?php

namespace Tests\Unit\Services;

use App\Actions\Registration\RegisterFamilyAction;
use App\Models\Child;
use App\Services\RegistrationService;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class RegistrationServiceTest extends TestCase
{
    private RegisterFamilyAction|MockInterface $registerFamilyAction;
    private RegistrationService $registrationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->registerFamilyAction = Mockery::mock(RegisterFamilyAction::class);
        $this->registrationService = new RegistrationService($this->registerFamilyAction);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_delegates_registration_to_register_family_action()
    {
        // Arrange
        $registrationData = [
            'email' => 'parent@example.com',
            'guardian_name' => 'John Doe',
            'guardian_phone' => '081234567890',
            'guardian_type' => 'father',
            'child_name' => 'Jane Doe',
            'child_gender' => 'female',
            'child_birth_place' => 'Jakarta',
            'child_birth_date' => '2020-01-15',
            'child_school' => 'TK Maju',
            'child_address' => 'Jl. Example No. 123',
            'child_complaint' => 'Speech delay',
            'child_service_choice' => 'therapy',
        ];

        $expectedChild = Mockery::mock(Child::class);

        $this->registerFamilyAction
            ->shouldReceive('execute')
            ->once()
            ->with($registrationData)
            ->andReturn($expectedChild);

        // Act
        $result = $this->registrationService->registration($registrationData);

        // Assert
        $this->assertSame($expectedChild, $result);
    }

    /** @test */
    public function it_returns_child_instance()
    {
        // Arrange
        $registrationData = [
            'email' => 'parent@example.com',
            'guardian_name' => 'John Doe',
            'guardian_phone' => '081234567890',
            'guardian_type' => 'mother',
            'child_name' => 'Baby Doe',
            'child_gender' => 'male',
            'child_birth_place' => 'Bandung',
            'child_birth_date' => '2021-05-20',
            'child_address' => 'Jl. Test No. 456',
            'child_complaint' => 'Hyperactive',
            'child_service_choice' => 'consultation',
        ];

        $child = Mockery::mock(Child::class);

        $this->registerFamilyAction
            ->shouldReceive('execute')
            ->once()
            ->with($registrationData)
            ->andReturn($child);

        // Act
        $result = $this->registrationService->registration($registrationData);

        // Assert
        $this->assertInstanceOf(Child::class, $result);
    }

    /** @test */
    public function it_passes_complete_registration_data_to_action()
    {
        // Arrange
        $registrationData = [
            'email' => 'test@example.com',
            'guardian_name' => 'Test Guardian',
            'guardian_phone' => '089876543210',
            'guardian_type' => 'other',
            'child_name' => 'Test Child',
            'child_gender' => 'female',
            'child_birth_place' => 'Surabaya',
            'child_birth_date' => '2019-03-10',
            'child_school' => 'SD Negeri 1',
            'child_address' => 'Jl. Testing No. 789',
            'child_complaint' => 'Learning difficulty',
            'child_service_choice' => 'assessment',
        ];

        $child = Mockery::mock(Child::class);

        $this->registerFamilyAction
            ->shouldReceive('execute')
            ->once()
            ->withArgs(function ($data) use ($registrationData) {
                return $data === $registrationData &&
                    $data['email'] === 'test@example.com' &&
                    $data['guardian_name'] === 'Test Guardian' &&
                    $data['child_name'] === 'Test Child';
            })
            ->andReturn($child);

        // Act
        $result = $this->registrationService->registration($registrationData);

        // Assert
        $this->assertInstanceOf(Child::class, $result);
    }

    /** @test */
    public function it_handles_registration_without_optional_school_field()
    {
        // Arrange
        $registrationData = [
            'email' => 'parent@example.com',
            'guardian_name' => 'Parent Name',
            'guardian_phone' => '081111111111',
            'guardian_type' => 'father',
            'child_name' => 'Child Name',
            'child_gender' => 'male',
            'child_birth_place' => 'Solo',
            'child_birth_date' => '2022-07-01',
            'child_address' => 'Jl. Solo No. 1',
            'child_complaint' => 'None',
            'child_service_choice' => 'screening',
        ];

        $child = Mockery::mock(Child::class);

        $this->registerFamilyAction
            ->shouldReceive('execute')
            ->once()
            ->with($registrationData)
            ->andReturn($child);

        // Act
        $result = $this->registrationService->registration($registrationData);

        // Assert
        $this->assertInstanceOf(Child::class, $result);
    }

    /** @test */
    public function it_handles_registration_with_null_school_field()
    {
        // Arrange
        $registrationData = [
            'email' => 'parent@example.com',
            'guardian_name' => 'Parent Name',
            'guardian_phone' => '082222222222',
            'guardian_type' => 'mother',
            'child_name' => 'Young Child',
            'child_gender' => 'female',
            'child_birth_place' => 'Semarang',
            'child_birth_date' => '2023-01-15',
            'child_school' => null, // Explicitly null
            'child_address' => 'Jl. Semarang No. 5',
            'child_complaint' => 'Developmental check',
            'child_service_choice' => 'consultation',
        ];

        $child = Mockery::mock(Child::class);

        $this->registerFamilyAction
            ->shouldReceive('execute')
            ->once()
            ->with($registrationData)
            ->andReturn($child);

        // Act
        $result = $this->registrationService->registration($registrationData);

        // Assert
        $this->assertInstanceOf(Child::class, $result);
    }

    /** @test */
    public function it_invokes_register_family_action_exactly_once()
    {
        // Arrange
        $registrationData = [
            'email' => 'single@call.com',
            'guardian_name' => 'Single Call',
            'guardian_phone' => '083333333333',
            'guardian_type' => 'father',
            'child_name' => 'Only Child',
            'child_gender' => 'male',
            'child_birth_place' => 'Yogyakarta',
            'child_birth_date' => '2020-12-25',
            'child_school' => 'PAUD Harapan',
            'child_address' => 'Jl. Yogya No. 10',
            'child_complaint' => 'Behavioral issue',
            'child_service_choice' => 'therapy',
        ];

        $child = Mockery::mock(Child::class);

        $this->registerFamilyAction
            ->shouldReceive('execute')
            ->once()
            ->with($registrationData)
            ->andReturn($child);

        // Act
        $this->registrationService->registration($registrationData);

        // Assert - Mockery verifies the 'once' expectation
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function it_passes_different_guardian_types_correctly()
    {
        // Arrange
        $guardianTypes = ['father', 'mother', 'other'];

        foreach ($guardianTypes as $guardianType) {
            $registrationData = [
                'email' => "guardian-{$guardianType}@example.com",
                'guardian_name' => 'Guardian Name',
                'guardian_phone' => '084444444444',
                'guardian_type' => $guardianType,
                'child_name' => 'Test Child',
                'child_gender' => 'male',
                'child_birth_place' => 'Jakarta',
                'child_birth_date' => '2021-06-01',
                'child_address' => 'Jl. Test No. 100',
                'child_complaint' => 'Test complaint',
                'child_service_choice' => 'therapy',
            ];

            $child = Mockery::mock(Child::class);

            $this->registerFamilyAction
                ->shouldReceive('execute')
                ->once()
                ->with($registrationData)
                ->andReturn($child);

            // Act
            $result = $this->registrationService->registration($registrationData);

            // Assert
            $this->assertInstanceOf(Child::class, $result);
        }
    }

    /** @test */
    public function it_passes_different_child_genders_correctly()
    {
        // Arrange
        $genders = ['male', 'female'];

        foreach ($genders as $gender) {
            $registrationData = [
                'email' => "parent-{$gender}@example.com",
                'guardian_name' => 'Parent Name',
                'guardian_phone' => '085555555555',
                'guardian_type' => 'mother',
                'child_name' => "Child {$gender}",
                'child_gender' => $gender,
                'child_birth_place' => 'Surabaya',
                'child_birth_date' => '2020-03-15',
                'child_address' => 'Jl. Test Gender No. 50',
                'child_complaint' => 'Development check',
                'child_service_choice' => 'assessment',
            ];

            $child = Mockery::mock(Child::class);

            $this->registerFamilyAction
                ->shouldReceive('execute')
                ->once()
                ->with($registrationData)
                ->andReturn($child);

            // Act
            $result = $this->registrationService->registration($registrationData);

            // Assert
            $this->assertInstanceOf(Child::class, $result);
        }
    }
}
