<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Organization\ClustersModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ClusterControllerTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * Helper method to create a cluster.
     * @param array $attributes
     * @return \App\Models\ClustersModel
     */
    protected function createCluster(array $attributes = []): ClustersModel
    {
        echo("first function");
        return ClustersModel::factory()->create($attributes);
    }

    #[Test]
    public function it_can_display_a_list_of_clusters()
    {
        // Arrange: Create some clusters
        $clusters = ClustersModel::factory()->count(3)->create();

        // Act: Make a GET request to the index route
        $response = $this->get(route('clusters.index'));

        // Assert: Check that the response is successful and contains the clusters
        $response->assertStatus(200);
        $response->assertViewHas('clusters', function ($viewClusters) use ($clusters) {
            return $viewClusters->count() === $clusters->count();
        });
    }

    #[Test]
    public function it_can_create_a_new_cluster()
    {
        // Arrange: Prepare cluster data
        $data = [
            'cluster_id' => '123e4567-e89b-12d3-a456-426614174000',
            'name' => 'Test Cluster',
            'description' => 'This is a test cluster.',
        ];

        // Act: Make a POST request to the store route
        $response = $this->post(route('clusters.store'), $data);

        // Assert: Check that the cluster was created and the response redirects
        $this->assertDatabaseHas('clusters', $data);
        $response->assertRedirect(route('clusters.index'));
    }

    #[Test]
    public function it_can_display_a_single_cluster()
    {
        // Arrange: Create a cluster
        $cluster = $this->createCluster();

        // Act: Make a GET request to the show route
        $response = $this->get(route('clusters.show', $cluster->cluster_id));

        // Assert: Check that the response is successful and contains the cluster
        $response->assertStatus(200);
        $response->assertViewHas('cluster', $cluster);
    }

    #[Test]
    public function it_can_update_an_existing_cluster()
    {
        // Arrange: Create a cluster
        $cluster = $this->createCluster();

        // Prepare updated data
        $data = [
            'name' => 'Updated Cluster',
            'description' => 'This is an updated cluster.',
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
        $cluster = $this->createCluster();

        // Act: Make a DELETE request to the destroy route
        $response = $this->delete(route('clusters.destroy', $cluster->cluster_id));

        // Assert: Check that the cluster was deleted and the response redirects
        $this->assertDatabaseMissing('clusters', ['cluster_id' => $cluster->cluster_id]);
        $response->assertRedirect(route('clusters.index'));
    }
}