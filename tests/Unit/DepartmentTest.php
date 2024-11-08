<?php

namespace Tests\Unit;

use App\Models\Organization\DepartmentsModel;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    use WithFaker;

    #[Test]
    public function it_displays_a_listing_of_the_resource()
    {
        $departments = DepartmentsModel::factory()->count(3)->create();

        $response = $this->get(route('departments.index'));

        $response->assertStatus(200);
        $response->assertViewIs('departments.index');
        $response->assertViewHas('departments', $departments);
    }

    #[Test]
    public function it_shows_the_form_for_creating_a_new_resource()
    {
        $response = $this->get(route('departments.create'));

        $response->assertStatus(200);
        $response->assertViewIs('departments.create');
    }

    #[Test]
    public function it_stores_a_newly_created_resource_in_storage()
    {
        $data = [
            'name' => $this->faker->word,
            'cluster_id' => $this->faker->randomNumber(),
        ];

        $response = $this->post(route('departments.store'), $data);

        $response->assertRedirect(route('departments.index'));
        $response->assertSessionHas('success', 'Department created successfully.');
        $this->assertDatabaseHas('departments', $data);
    }

    #[Test]
    public function it_displays_the_specified_resource()
    {
        $department = DepartmentsModel::factory()->create();

        $response = $this->get(route('departments.show', $department));

        $response->assertStatus(200);
        $response->assertViewIs('departments.show');
        $response->assertViewHas('department', $department);
    }

    #[Test]
    public function it_shows_the_form_for_editing_the_specified_resource()
    {
        $department = DepartmentsModel::factory()->create();

        $response = $this->get(route('departments.edit', $department));

        $response->assertStatus(200);
        $response->assertViewIs('departments.edit');
        $response->assertViewHas('department', $department);
    }

    #[Test]
    public function it_updates_the_specified_resource_in_storage()
    {
        $department = DepartmentsModel::factory()->create();

        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ];

        $response = $this->put(route('departments.update', $department), $data);

        $response->assertRedirect(route('departments.index'));
        $response->assertSessionHas('success', 'Department updated successfully.');
        $this->assertDatabaseHas('departments', $data);
    }

    #[Test]
    public function it_removes_the_specified_resource_from_storage()
    {
        $department = DepartmentsModel::factory()->create();

        $response = $this->delete(route('departments.destroy', $department));

        $response->assertRedirect(route('departments.index'));
        $response->assertSessionHas('success', 'Department deleted successfully.');
        $this->assertDatabaseMissing('departments', ['id' => $department->id]);
    }
}
