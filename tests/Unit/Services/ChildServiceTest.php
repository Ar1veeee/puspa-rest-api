<?php

namespace Tests\Unit\Services;

use App\Actions\Child\UpdateChildWithFamilyAction;
use App\Models\Child;
use App\Services\ChildService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ChildServiceTest extends TestCase
{
    use RefreshDatabase; // Gunakan database in-memory, cepat dan aman

    private ChildService $childService;

    /** @var UpdateChildWithFamilyAction|MockInterface */
    private $updateActionMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock Action
        $this->updateActionMock = Mockery::mock(UpdateChildWithFamilyAction::class);

        // Inject mock Action ke service
        $this->childService = new ChildService($this->updateActionMock);
    }

    /** @test */
    public function get_all_child_returns_collection_of_children_with_family_and_guardians()
    {
        // Buat data dummy langsung di database in-memory
        Child::factory()->count(3)->create();

        $result = $this->childService->getAllChild();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(3, $result);
        $this->assertTrue($result->first()->relationLoaded('family'));
    }

    /** @test */
    public function update_calls_update_action_with_correct_parameters_and_returns_child()
    {
        $child = Child::factory()->create();
        $data = ['name' => 'Updated Name', 'birth_date' => '2020-01-01'];

        $updatedChild = $child;
        $updatedChild->name = 'Updated Name';

        $this->updateActionMock
            ->shouldReceive('execute')
            ->once()
            ->with($child, $data)
            ->andReturn($updatedChild);

        $result = $this->childService->update($data, $child);

        $this->assertSame($updatedChild, $result);
    }

    /** @test */
    public function destroy_calls_delete_on_child_model_and_returns_true_on_success()
    {
        $child = Mockery::mock(Child::class)->makePartial();
        $child->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        $result = $this->childService->destroy($child);

        $this->assertTrue($result);
    }

    /** @test */
    public function destroy_returns_false_when_delete_fails()
    {
        $child = Mockery::mock(Child::class)->makePartial();
        $child->shouldReceive('delete')
            ->once()
            ->andReturn(false);

        $result = $this->childService->destroy($child);

        $this->assertFalse($result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
