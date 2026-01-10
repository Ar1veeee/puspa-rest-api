<?php

namespace Tests\Unit\Services;

use App\Actions\Therapist\CreateTherapistAction;
use App\Actions\Therapist\DeleteTherapistAction;
use App\Actions\Therapist\UpdateProfileTherapistAction;
use App\Actions\Therapist\UpdateTherapistAction;
use App\Models\Therapist;
use App\Models\User;
use App\Services\TherapistService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class TherapistServiceTest extends TestCase
{
    use RefreshDatabase;

    private TherapistService $therapistService;

    /** @var CreateTherapistAction|MockInterface */
    private $createActionMock;

    /** @var UpdateTherapistAction|MockInterface */
    private $updateActionMock;

    /** @var UpdateProfileTherapistAction|MockInterface */
    private $updateProfileActionMock;

    /** @var DeleteTherapistAction|MockInterface */
    private $deleteActionMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createActionMock = Mockery::mock(CreateTherapistAction::class);
        $this->updateActionMock = Mockery::mock(UpdateTherapistAction::class);
        $this->updateProfileActionMock = Mockery::mock(UpdateProfileTherapistAction::class);
        $this->deleteActionMock = Mockery::mock(DeleteTherapistAction::class);

        $this->therapistService = new TherapistService(
            $this->createActionMock,
            $this->updateActionMock,
            $this->updateProfileActionMock,
            $this->deleteActionMock
        );
    }

    /** @test */
    public function index_returns_active_therapists_with_user_relation()
    {
        $activeUser1 = User::factory()->create(['is_active' => true]);
        $activeUser2 = User::factory()->create(['is_active' => true]);
        $therapist1 = Therapist::factory()->create(['user_id' => $activeUser1->id]);
        $therapist2 = Therapist::factory()->create(['user_id' => $activeUser2->id]);

        $inactiveUser = User::factory()->create(['is_active' => false]);
        Therapist::factory()->create(['user_id' => $inactiveUser->id]);

        $result = $this->therapistService->index();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
        $this->assertTrue($result->contains($therapist1));
        $this->assertTrue($result->contains($therapist2));

        $first = $result->first();
        $this->assertTrue($first->relationLoaded('user'));

        $user = $first->user;

        $this->assertNotNull($user->username);
        $this->assertNotNull($user->email);
        $this->assertNotNull($user->is_active);

        $this->assertNull($user->password ?? null);
    }

    /** @test */
    public function show_loads_user_relation_with_limited_fields()
    {
        $user = User::factory()->create(['is_active' => true]);
        $therapist = Therapist::factory()->create(['user_id' => $user->id]);

        $result = $this->therapistService->show($therapist);

        $this->assertSame($therapist, $result);
        $this->assertTrue($result->relationLoaded('user'));

        $loadedUser = $result->user;

        $this->assertNotNull($loadedUser->username);
        $this->assertNotNull($loadedUser->email);
        $this->assertNotNull($loadedUser->is_active);

        $this->assertNull($loadedUser->password ?? null);
    }

    /** @test */
    public function store_calls_create_therapist_action_and_returns_therapist()
    {
        $data = [
            'therapist_name' => 'Dr. Andi',
            'email' => 'andi@clinic.com',
        ];

        $expectedTherapist = Therapist::factory()->make();

        $this->createActionMock
            ->shouldReceive('execute')
            ->once()
            ->with($data)
            ->andReturn($expectedTherapist);

        $result = $this->therapistService->store($data);

        $this->assertSame($expectedTherapist, $result);
    }

    /** @test */
    public function update_calls_update_therapist_action_with_correct_parameters()
    {
        $therapist = Therapist::factory()->create();
        $data = ['therapist_name' => 'Updated Name'];

        $updatedTherapist = $therapist;
        $updatedTherapist->therapist_name = 'Updated Name';

        $this->updateActionMock
            ->shouldReceive('execute')
            ->once()
            ->with($therapist, $data)
            ->andReturn($updatedTherapist);

        $result = $this->therapistService->update($data, $therapist);

        $this->assertSame($updatedTherapist, $result);
    }

    /** @test */
    public function update_profile_calls_update_profile_action_with_correct_parameters()
    {
        $therapist = Therapist::factory()->create();
        $data = ['phone' => '08123456789'];

        $updatedTherapist = $therapist;
        $updatedTherapist->phone = '08123456789';

        $this->updateProfileActionMock
            ->shouldReceive('execute')
            ->once()
            ->with($therapist, $data)
            ->andReturn($updatedTherapist);

        $result = $this->therapistService->updateProfile($data, $therapist);

        $this->assertSame($updatedTherapist, $result);
    }

    /** @test */
    public function destroy_calls_delete_therapist_action()
    {
        $therapist = Therapist::factory()->create();

        $this->deleteActionMock
            ->shouldReceive('execute')
            ->once()
            ->with($therapist);

        $this->therapistService->destroy($therapist);

        $this->assertTrue(true);
    }

    /** @test */
    public function get_profile_returns_therapist_with_user_for_given_user_id()
    {
        $user = User::factory()->create();
        $therapist = Therapist::factory()->create(['user_id' => $user->id]);

        Therapist::factory()->create();

        $result = $this->therapistService->getProfile($user->id);

        $this->assertInstanceOf(Therapist::class, $result);
        $this->assertEquals($therapist->id, $result->id);
        $this->assertTrue($result->relationLoaded('user'));
        $this->assertEquals($user->id, $result->user->id);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
