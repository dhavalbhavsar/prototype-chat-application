<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test Create Group
     *
     * @return void
     */
    public function testCreateGroup()
    {
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->text(10)
        ];

        $response = $this->postJson('/api/group/create/'.$user->id,$data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    /**
     * Test Add User Group
     *
     * @return void
     */
    public function testAddUserGroup()
    {
        $user = User::factory()->create();

        $groupData = [
            'name' => $this->faker->text(10)
        ];

        $response = $this->postJson('/api/group/create/'.$user->id,$groupData)->getOriginalContent();

        $userToAddGroup = User::factory()->create();

        $data = [
            'user_id' => $userToAddGroup->id
        ];

        $response = $this->postJson('/api/group/add-user/'.$response['data']->id.'/'.$user->id,$data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    /**
     * Test Add User Group
     *
     * @return void
     */
    public function testRemoveUserGroup()
    {
        $user = User::factory()->create();

        $groupData = [
            'name' => $this->faker->text(10)
        ];

        $response = $this->postJson('/api/group/create/'.$user->id,$groupData)->getOriginalContent();

        $userToAddGroup = User::factory()->create();

        $data = [
            'user_id' => $userToAddGroup->id
        ];

        $responseAddUser = $this->postJson('/api/group/add-user/'.$response['data']->id.'/'.$user->id,$data);

        $data = [
            'user_id' => $userToAddGroup->id
        ];

        $responseRemoveUser = $this->postJson('/api/group/remove-user/'.$response['data']->id.'/'.$user->id,$data);

        $responseRemoveUser
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }


    /**
     * Test Group Validation
     *
     * @return void
     */
    public function testCreateGroupValidationRequiredName()
    {
        $user = User::factory()->create();

        $data = [
            'name' => ''
        ];

        $response = $this->postJson('/api/group/create/'.$user->id,$data);

        $response->assertStatus(422);
    }

    /**
     * Create message
     *
     * @return void
     */
    public function testCreateMessage()
    {

        $user = User::factory()->create();

        $groupData = [
            'name' => 'Test Group'
        ];
    
        $response = $this->postJson('/api/group/create/'.$user->id,$groupData)->getOriginalContent();

        $data = [
            'message' => 'Hi Test'
        ];  

        $response = $this->postJson('/api/message/create/'.$response['data']->id.'/'.$response['data']->created_by, $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    /**
     * List message
     *
     * @return void
     */
    public function testListMessage()
    {

        $user = User::factory()->create();

        $groupData = [
            'name' => 'Test Group'
        ];
    
        $response = $this->postJson('/api/group/create/'.$user->id,$groupData)->getOriginalContent();

        $data = [
            'message' => 'Hi Test'
        ];  

        $responseMessage = $this->postJson('/api/message/create/'.$response['data']->id.'/'.$response['data']->created_by, $data);

        $response = $this->getJson('/api/message/list/'.$response['data']->id.'/'.$response['data']->created_by);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

    }

}
