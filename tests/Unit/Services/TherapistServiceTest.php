<?php

namespace Tests\Unit\Services;

use App\Http\Repositories\TherapistRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Services\TherapistService;
use App\Models\Therapist;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class TherapistServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TherapistService $therapistService;
    protected User $therapistUser;
    protected Therapist $therapist;

    protected function setUp(): void
    {
        parent::setUp();
        $this->therapistService = new TherapistService(
            new UserRepository(new User()),
            new TherapistRepository(new Therapist())
        );

        $this->therapistUser = User::factory()->create(['role' => 'terapis']);
        $this->therapist = Therapist::factory()->create(['user_id' => $this->therapistUser->id]);
    }

    /**
     * @test
     * Testing show all therapist success.
     */
    public function getAllTherapistShouldReturnFormattedArrayOfTherapists(): void
    {
        $result = $this->therapistService->getAllTherapist();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals($this->therapistUser->email, $result[0]['email']);
        $this->assertEquals($this->therapist->therapist_name, $result[0]['therapist_name']);
    }

    /**
     * @test
     * Testing get therapist detail success.
     */
    public function getTherapistDetailShouldReturnFormattedData(): void
    {
        $result = $this->therapistService->getTherapistDetail($this->therapist->id);

        $this->assertIsArray($result);
        $this->assertEquals($this->therapistUser->username, $result['username']);
        $this->assertEquals($this->therapist->id, $result['id']);
    }

    /**
     * @test
     * Testing get therapist detail failed with invalid id.
     */
    public function getTherapistDetailShouldThrowExceptionForInvalidId(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Data terapis tidak ditemukan.');

        $this->therapistService->getTherapistDetail('non-existent-id');
    }

    /**
     * @test
     * Testing create therapist success with valid data.
     */
    public function createTherapistShouldSucceedWithValidData(): void
    {
        $data = [
            'username' => 'newterapis',
            'email' => 'new@terapis.com',
            'password' => 'password123',
            'therapist_name' => 'Dr. Baru',
            'therapist_section' => 'Okupasi',
            'therapist_phone' => '081234567890',
        ];

        $this->therapistService->createTherapist($data);

        $this->assertDatabaseHas('users', ['username' => 'newterapis']);
        $this->assertDatabaseHas('therapists', ['therapist_name' => 'Dr. Baru']);
    }

    /**
     * @test
     * Testing update therapist success with valid data.
     */
    public function updateTherapistShouldSucceedWithValidData(): void
    {
        $updateData = [
            'username' => 'updated_username',
            'therapist_name' => 'Nama Terapis Update',
            'password' => 'newPassword123'
        ];

        $this->therapistService->updateTherapist($updateData, $this->therapist->id);

        $this->assertDatabaseHas('users', ['username' => 'updated_username']);
        $this->assertDatabaseHas('therapists', ['therapist_name' => 'Nama Terapis Update']);

        $updatedUser = User::find($this->therapistUser->id);
        $this->assertTrue(Hash::check('newPassword123', $updatedUser->password));
    }

    /**
     * @test
     * Testing update therapist failed with duplicate email.
     */
    public function updateTherapistShouldThrowExceptionForDuplicateEmail(): void
    {
        $this->expectException(ValidationException::class);
        User::factory()->create(['email' => 'taken@email.com']);

        $updateData = ['email' => 'taken@email.com'];

        $this->therapistService->updateTherapist($updateData, $this->therapist->id);
    }

    /**
     * @test
     * Testing delete therapist success.
     */
    public function deleteTherapistShouldOnlyDeleteTherapistRecord(): void
    {
        $therapistId = $this->therapist->id;
        $userId = $this->therapistUser->id;

        $this->therapistService->deleteTherapist($therapistId);

        $this->assertDatabaseMissing('therapists', ['id' => $therapistId]);
        $this->assertDatabaseHas('users', ['id' => $userId]);
    }
}
