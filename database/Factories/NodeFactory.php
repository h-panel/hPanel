<?php

namespace Database\Factories;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Pterodactyl\Models\Node;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Factories\Factory;

class NodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Node::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'uuid' => Uuid::uuid4()->toString(),
            'public' => true,
            'name' => 'FactoryNode_' . Str::random(10),
            'fqdn' => $this->faker->unique()->ipv4,
            'scheme' => 'http',
            'behind_proxy' => false,
            'memory' => 1024,
            'memory_overallocate' => 0,
            'disk' => 10240,
            'disk_overallocate' => 0,
            'upload_size' => 100,
            'daemon_token_id' => Str::random(Node::DAEMON_TOKEN_ID_LENGTH),
            'daemon_token' => Crypt::encrypt(Str::random(Node::DAEMON_TOKEN_LENGTH)),
            'daemonListen' => 8080,
            'daemonSFTP' => 2022,
            'daemonBase' => '/var/lib/pterodactyl/volumes',
        ];
    }
}
