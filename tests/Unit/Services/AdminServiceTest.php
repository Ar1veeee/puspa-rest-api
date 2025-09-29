<?php

namespace Tests\Unit\Services;

use App\Http\Repositories\AdminRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Services\AdminService;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AdminServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AdminService $adminService;
    protected User $adminUser;
    protected Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminService = new AdminService(
            new UserRepository(new User()),
            new AdminRepository(new Admin())
        );

        $this->admin = Admin::factory()->create();
        $this->adminUser = $this->admin->user;
    }

    /** @test
     * Testing show all admin success.
     */
    public function getAllAdminShouldReturnFormattedArrayOfAdmins(): void
    {
        $result = $this->adminService->getAllAdmin();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);

        $firstAdmin = $result->first();
        $this->assertEquals($this->adminUser->email, $firstAdmin->user->email);
        $this->assertEquals($this->admin->admin_name, $firstAdmin->admin_name);
    }

    /** @test
     * Testing get admin detail success.
     */
    public function getAdminDetailShouldReturnAdminModel(): void
    {
        $result = $this->adminService->getAdminDetail($this->admin->id);

        $this->assertInstanceOf(Admin::class, $result);
        $this->assertEquals($this->adminUser->username, $result->user->username);
        $this->assertEquals($this->admin->id, $result->id);
    }

    /** @test
     * Testing get admin detail failed with invalid id.
     */
    public function getAdminDetailShouldThrowExceptionForInvalidId(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Data admin tidak ditemukan.');

        $this->adminService->getAdminDetail('non-existent-id');
    }

    /** @test
     * Testing create admin success with valid data.
     */
    public function createAdminShouldSucceedWithValidData(): void
    {
        $data = [
            'username' => 'newadmin',
            'email' => 'new@admin.com',
            'password' => 'password123',
            'admin_name' => 'Admin Baru',
            'admin_phone' => '081234567890',
        ];

        $this->adminService->createAdmin($data);

        $this->assertDatabaseHas('users', ['username' => 'newadmin', 'role' => 'admin']);
        $this->assertDatabaseHas('admins', ['admin_name' => 'Admin Baru']);
    }

    /** @test
     * Testing update admin success with valid data.
     */
    public function updateAdminShouldSucceedWithValidData(): void
    {
        $updateData = [
            'username' => 'updated_admin_username',
            'admin_name' => 'Nama Admin Update',
            'password' => 'newPassword123'
        ];

        $this->adminService->updateAdmin($updateData, $this->admin->id);

        $this->assertDatabaseHas('users', ['username' => 'updated_admin_username']);
        $this->assertDatabaseHas('admins', ['admin_name' => 'Nama Admin Update']);

        $updatedUser = $this->adminUser->fresh();
        $this->assertTrue(Hash::check('newPassword123', $updatedUser->password));
    }

    /** @test
     * Testing update admin failed with duplicate email.
     */
    public function updateAdminShouldThrowExceptionForDuplicateEmail(): void
    {
        $this->expectException(ValidationException::class);
        User::factory()->create(['email' => 'taken@email.com']);

        $updateData = ['email' => 'taken@email.com'];

        $this->adminService->updateAdmin($updateData, $this->admin->id);
    }

    /** @test
     * Testing delete admin success.
     */
    public function deleteAdminShouldOnlyDeleteAdminRecordAndNotTheUser(): void
    {
        $adminId = $this->admin->id;
        $userId = $this->adminUser->id;

        $this->adminService->deleteAdmin($adminId);

        $this->assertDatabaseMissing('admins', ['id' => $adminId]);
        $this->assertDatabaseHas('users', ['id' => $userId]);
    }
}
