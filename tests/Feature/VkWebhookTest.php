<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\RefreshDatabaseOnce;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class VkWebhookTest extends TestCase
{
    use RefreshDatabaseOnce;

    const PATH = '/vk/webhook';
    const OK_TEXT = 'ok';

    protected $secret = null;

    public function __construct()
    {
        parent::__construct();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->secret = config('services.vkontakte_webhook.secret');
    }

    public function test_cannot_accept_get()
    {
        $response = $this->get(self::PATH);

        $response->assertStatus(405);
    }

    public function test_can_accept_empty_request()
    {
        $response = $this->post(self::PATH);

        $response->assertStatus(200);
    }

    public function test_returns_ok_on_empty_request()
    {
        $response = $this->post(self::PATH);

        $response->assertSee(self::OK_TEXT);
    }

    public function test_returns_token_for_group_confirmation_if_secret_passed()
    {
        $group = Group::factory()->create();
        $body = [
            'type' => 'confirmation',
            'group_id' => $group->vk_id,
            'secret' => $this->secret,
        ];
        $response = $this->postJson(self::PATH, $body);

        $response->assertSee($group->vk_confirmation_token);
    }

    public function test_does_not_return_token_for_group_confirmation_if_secret_not_passed()
    {
        $group = Group::factory()->create();
        $body = [
            'type' => 'confirmation',
            'group_id' => $group->vk_id,
        ];
        $response = $this->postJson(self::PATH, $body);

        $response->assertDontSee($group->vk_confirmation_token);
    }

    public function test_returns_ok_on_any_type()
    {
        $body = [
            'type' => Str::random(10),
            'secret' => $this->secret,
        ];
        $response = $this->postJson(self::PATH, $body);

        $response->assertSee(self::OK_TEXT);
    }

    public function test_can_add_simple_post_with_valid_data()
    {
        $postSigner = User::factory()->create();
        $postCreator = User::factory()->create();
        $group = Group::factory()->create();
        $postVkId = rand(1, 100);
        $postText = Str::random(20);
        $body = [
            'type' => 'wall_post_new',
            'object' => [
                'id' => $postVkId,
                'from_id' => -$group->vk_id,
                'owner_id' => -$group->vk_id,
                'date' => time(),
                'marked_as_ads' => 0,
                'post_type' => 'post',
                'text' => $postText,
                'signer_id' => $postSigner->vk_id,
                'created_by' => $postCreator->vk_id,
            ],
            'group_id' => $group->vk_id,
            'secret' => $this->secret,
        ];
        $response = $this->postJson(self::PATH, $body);

        $response->assertSee(self::OK_TEXT);
        $post = Post::where('group_id', $group->id)->where('vk_id', $postVkId)->first();
        assertNotNull($post);
        assertEquals($post->text, $postText);
        assertEquals($post->signer_id, $postSigner->id);
        assertEquals($post->creator_id, $postCreator->id);
    }
}
