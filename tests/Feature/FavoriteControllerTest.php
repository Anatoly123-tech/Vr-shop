<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();

        // Создаём пользователя и продукт для всех тестов
        $this->user = User::factory()->create();
        $this->product = Product::factory()->create();
    }

    /** @test */
    public function authenticated_user_can_add_product_to_favorites()
    {
        $response = $this->actingAs($this->user)
            ->post(route('favorites.toggle', $this->product));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Товар добавлен в избранное.');
        $this->assertTrue($this->user->favorites()->where('product_id', $this->product->id)->exists());
    }

    /** @test */
    public function authenticated_user_can_remove_product_from_favorites()
    {
        // Сначала добавляем товар в избранное
        $this->user->favorites()->attach($this->product->id);

        $response = $this->actingAs($this->user)
            ->post(route('favorites.toggle', $this->product));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Товар удален из избранного.');
        $this->assertFalse($this->user->favorites()->where('product_id', $this->product->id)->exists());
    }

    /** @test */
    public function unauthenticated_user_cannot_toggle_favorites()
    {
        $response = $this->post(route('favorites.toggle', $this->product));

        $response->assertRedirect(route('login'));
        $this->assertFalse($this->product->favoritedBy()->where('product_id', $this->product->id)->exists());
    }

    /** @test */
    public function authenticated_user_can_view_favorites()
    {
        // Добавляем несколько товаров в избранное
        $this->user->favorites()->attach($this->product->id);
        $anotherProduct = Product::factory()->create();
        $this->user->favorites()->attach($anotherProduct->id);

        $response = $this->actingAs($this->user)
            ->get(route('favorites.index'));

        $response->assertStatus(200);
        $response->assertViewIs('favorites.index');
        $response->assertViewHas('favorites', function ($favorites) use ($anotherProduct) {
            return $favorites->count() === 2
                && $favorites->contains($this->product)
                && $favorites->contains($anotherProduct);
        });
    }

    /** @test */
    public function unauthenticated_user_cannot_view_favorites()
    {
        $response = $this->get(route('favorites.index'));

        $response->assertRedirect(route('login'));
    }
}
