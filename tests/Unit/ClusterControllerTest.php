<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Organization\ClustersModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Str;

class ClusterControllerTest extends TestCase
{
    // use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user to satisfy the foreign key constraint
        $this->user = User::factory()->create();
    }

    /**
     * Helper method to create a cluster.
     *
     * @param array $attributes
     * @return \App\Models\Organization\ClustersModel
     */
    protected function createCluster(array $attributes = []): ClustersModel
    {
        return ClustersModel::factory()->create(array_merge([
            'created_by' => $this->user->id,
        ], $attributes));
    }

    #[Test]
    public function it_can_display_a_list_of_clusters()
    {
        // Arrange: Create some clusters
        $clusters = ClustersModel::factory()->count(3)->create(['created_by' => $this->user->id]);

        // Act: Make a GET request to the index route
        $response = $this->get(route('clusters.index'));

        // Assert: Check that the response is successful and contains the clusters
        $response->assertStatus(200);
        $response->assertViewHas('clusters', function ($viewClusters) use ($clusters) {
            return $viewClusters->count() === $clusters->count();
        });
    }

    #[Test]
    public function test_it_can_create_a_new_cluster()
    {
        // Arrange: Prepare cluster data
        $data = [
            'name' => 'Updated Cluster',
            'created_by' => 'd1368de7-d75c-4b93-81cc-9fce5b8254ab',
        ];
    
        // Act: Make a POST request to the store route
        $response = $this->post(route('clusters.store'), $data);
    
        // Assert: Check that a cluster was created with the correct name and created_by
        $this->assertDatabaseHas('clusters', [
            'name' => $data['name'],
            'created_by' => $data['created_by'],
        ]);
    
        $cluster = ClustersModel::where('name', $data['name'])->first();
        $this->assertNotNull($cluster);
        $this->assertTrue(Str::isUuid($cluster->cluster_id));
    
        $response->assertRedirect(route('clusters.index'));
    }
    

    #[Test]
    public function it_can_update_a_cluster()
    {
        // Arrange: Create a cluster
        $cluster = $this->createCluster(['created_by' => $this->user->id]);

        // Prepare updated data
        $data = [
            'name' => 'Updated Cluster',
            'created_by' => $this->user->id, // Ensure created_by is provided
        ];

        // Act: Make a PUT request to the update route
        $response = $this->put(route('clusters.update', $cluster->cluster_id), $data);

        // Assert: Check that the cluster was updated and the response redirects
        $this->assertDatabaseHas('clusters', array_merge(['cluster_id' => $cluster->cluster_id], $data));
        $response->assertRedirect(route('clusters.index'));
    }

    #[Test]
    public function it_can_delete_a_cluster()
    {
        // Arrange: Create a cluster
        $cluster = $this->createCluster(['created_by' => $this->user->id]);

        // Act: Make a DELETE request to the destroy route
        $response = $this->delete(route('clusters.destroy', $cluster->cluster_id));

        // Assert: Check that the cluster was deleted and the response redirects
        $this->assertDatabaseMissing('clusters', ['cluster_id' => $cluster->cluster_id]);
        $response->assertRedirect(route('clusters.index'));
    }
}
