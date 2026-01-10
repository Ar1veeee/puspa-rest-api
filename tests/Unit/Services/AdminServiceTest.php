<?php

namespace Tests\Unit\Services;

use App\Actions\Admin\CreateAdminAction;
use App\Actions\Admin\DeleteAdminAction;
use App\Actions\Admin\UpdateAdminAction;
use App\Actions\Admin\UpdateProfileAdminAction;
use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class AdminServiceTest extends TestCase
{
    private CreateAdminAction|MockInterface $createAdminAction;
    private UpdateAdminAction|MockInterface $updateAdminAction;
    private UpdateProfileAdminAction|MockInterface $updateProfileAdminAction;
    private DeleteAdminAction|MockInterface $deleteAdminAction;
    private AdminService $adminService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAdminAction = Mockery::mock(CreateAdminAction::class);
        $this->updateAdminAction = Mockery::mock(UpdateAdminAction::class);
        $this->updateProfileAdminAction = Mockery::mock(UpdateProfileAdminAction::class);
        $this->deleteAdminAction = Mockery::mock(DeleteAdminAction::class);

        $this->adminService = new AdminService(
            $this->createAdminAction,
            $this->updateAdminAction,
            $this->updateProfileAdminAction,
            $this->deleteAdminAction
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_delegates_store_to_create_admin_action()
    {
        // Arrange
        $data = [
            'username' => 'adminuser',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'admin_name' => 'Admin Name',
            'admin_phone' => '081234567890',
        ];

        $expectedAdmin = Mockery::mock(Admin::class);

        $this->createAdminAction
            ->shouldReceive('execute')
            ->once()
            ->with($data)
            ->andReturn($expectedAdmin);

        // Act
        $result = $this->adminService->store($data);

        // Assert
        $this->assertSame($expectedAdmin, $result);
    }

    /** @test */
    public function store_returns_admin_instance()
    {
        // Arrange
        $data = [
            'username' => 'newadmin',
            'email' => 'newadmin@example.com',
            'password' => 'secret123',
            'admin_name' => 'New Admin',
            'admin_phone' => '089876543210',
        ];

        $admin = Mockery::mock(Admin::class);

        $this->createAdminAction
            ->shouldReceive('execute')
            ->once()
            ->with($data)
            ->andReturn($admin);

        // Act
        $result = $this->adminService->store($data);

        // Assert
        $this->assertInstanceOf(Admin::class, $result);
    }

    /** @test */
    public function it_delegates_update_to_update_admin_action()
    {
        // Arrange
        $admin = Mockery::mock(Admin::class);
        $data = [
            'admin_name' => 'Updated Name',
            'admin_phone' => '081111111111',
        ];

        $updatedAdmin = Mockery::mock(Admin::class);

        $this->updateAdminAction
            ->shouldReceive('execute')
            ->once()
            ->with($admin, $data)
            ->andReturn($updatedAdmin);

        // Act
        $result = $this->adminService->update($data, $admin);

        // Assert
        $this->assertSame($updatedAdmin, $result);
    }

    /** @test */
    public function update_returns_admin_instance()
    {
        // Arrange
        $admin = Mockery::mock(Admin::class);
        $data = ['admin_name' => 'Modified Name'];

        $updatedAdmin = Mockery::mock(Admin::class);

        $this->updateAdminAction
            ->shouldReceive('execute')
            ->once()
            ->with($admin, $data)
            ->andReturn($updatedAdmin);

        // Act
        $result = $this->adminService->update($data, $admin);

        // Assert
        $this->assertInstanceOf(Admin::class, $result);
    }

    /** @test */
    public function it_delegates_update_profile_to_update_profile_admin_action()
    {
        // Arrange
        $admin = Mockery::mock(Admin::class);
        $data = [
            'admin_name' => 'Profile Updated',
            'admin_phone' => '082222222222',
        ];

        $updatedAdmin = Mockery::mock(Admin::class);

        $this->updateProfileAdminAction
            ->shouldReceive('execute')
            ->once()
            ->with($admin, $data)
            ->andReturn($updatedAdmin);

        // Act
        $result = $this->adminService->updateProfile($data, $admin);

        // Assert
        $this->assertSame($updatedAdmin, $result);
    }

    /** @test */
    public function update_profile_returns_admin_instance()
    {
        // Arrange
        $admin = Mockery::mock(Admin::class);
        $data = ['admin_phone' => '083333333333'];

        $updatedAdmin = Mockery::mock(Admin::class);

        $this->updateProfileAdminAction
            ->shouldReceive('execute')
            ->once()
            ->with($admin, $data)
            ->andReturn($updatedAdmin);

        // Act
        $result = $this->adminService->updateProfile($data, $admin);

        // Assert
        $this->assertInstanceOf(Admin::class, $result);
    }

    /** @test */
    public function it_delegates_destroy_to_delete_admin_action()
    {
        // Arrange
        $admin = Mockery::mock(Admin::class);

        $this->deleteAdminAction
            ->shouldReceive('execute')
            ->once()
            ->with($admin)
            ->andReturnNull();

        // Act
        $this->adminService->destroy($admin);

        // Assert - Mockery verifies expectations
        $this->assertTrue(true);
    }

    /** @test */
    public function destroy_returns_void()
    {
        // Arrange
        $admin = Mockery::mock(Admin::class);

        $this->deleteAdminAction
            ->shouldReceive('execute')
            ->once()
            ->with($admin)
            ->andReturnNull();

        // Act
        $result = $this->adminService->destroy($admin);

        // Assert
        $this->assertNull($result);
    }

    /** @test */
    public function it_passes_correct_admin_instance_to_update_action()
    {
        // Arrange
        $admin = Mockery::mock(Admin::class);
        $data = ['admin_name' => 'Test Name'];
        $updatedAdmin = Mockery::mock(Admin::class);

        $this->updateAdminAction
            ->shouldReceive('execute')
            ->once()
            ->withArgs(function ($passedAdmin, $passedData) use ($admin, $data) {
                return $passedAdmin === $admin && $passedData === $data;
            })
            ->andReturn($updatedAdmin);

        // Act
        $result = $this->adminService->update($data, $admin);

        // Assert
        $this->assertInstanceOf(Admin::class, $result);
    }

    /** @test */
    public function it_passes_correct_admin_instance_to_update_profile_action()
    {
        // Arrange
        $admin = Mockery::mock(Admin::class);
        $data = ['admin_phone' => '084444444444'];
        $updatedAdmin = Mockery::mock(Admin::class);

        $this->updateProfileAdminAction
            ->shouldReceive('execute')
            ->once()
            ->withArgs(function ($passedAdmin, $passedData) use ($admin, $data) {
                return $passedAdmin === $admin && $passedData === $data;
            })
            ->andReturn($updatedAdmin);

        // Act
        $result = $this->adminService->updateProfile($data, $admin);

        // Assert
        $this->assertInstanceOf(Admin::class, $result);
    }

    /** @test */
    public function it_passes_correct_admin_instance_to_delete_action()
    {
        // Arrange
        $admin = Mockery::mock(Admin::class);

        $this->deleteAdminAction
            ->shouldReceive('execute')
            ->once()
            ->withArgs(function ($passedAdmin) use ($admin) {
                return $passedAdmin === $admin;
            })
            ->andReturnNull();

        // Act
        $this->adminService->destroy($admin);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function store_invokes_create_action_exactly_once()
    {
        // Arrange
        $data = [
            'username' => 'onceadmin',
            'email' => 'once@example.com',
            'password' => 'password',
            'admin_name' => 'Once Admin',
            'admin_phone' => '085555555555',
        ];

        $admin = Mockery::mock(Admin::class);

        $this->createAdminAction
            ->shouldReceive('execute')
            ->once()
            ->with($data)
            ->andReturn($admin);

        // Act
        $this->adminService->store($data);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function update_invokes_update_action_exactly_once()
    {
        // Arrange
        $admin = Mockery::mock(Admin::class);
        $data = ['admin_name' => 'Single Update'];
        $updatedAdmin = Mockery::mock(Admin::class);

        $this->updateAdminAction
            ->shouldReceive('execute')
            ->once()
            ->with($admin, $data)
            ->andReturn($updatedAdmin);

        // Act
        $this->adminService->update($data, $admin);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function update_profile_invokes_update_profile_action_exactly_once()
    {
        // Arrange
        $admin = Mockery::mock(Admin::class);
        $data = ['admin_phone' => '086666666666'];
        $updatedAdmin = Mockery::mock(Admin::class);

        $this->updateProfileAdminAction
            ->shouldReceive('execute')
            ->once()
            ->with($admin, $data)
            ->andReturn($updatedAdmin);

        // Act
        $this->adminService->updateProfile($data, $admin);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function destroy_invokes_delete_action_exactly_once()
    {
        // Arrange
        $admin = Mockery::mock(Admin::class);

        $this->deleteAdminAction
            ->shouldReceive('execute')
            ->once()
            ->with($admin)
            ->andReturnNull();

        // Act
        $this->adminService->destroy($admin);

        // Assert
        $this->expectNotToPerformAssertions();
    }
}
