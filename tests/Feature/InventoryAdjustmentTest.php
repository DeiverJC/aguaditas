<?php

use App\Models\Inventory;
use App\Models\InventoryAdjustment;
use App\Models\InventoryAdjustmentItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->product = Product::factory()->create();
});

test('can list all inventory adjustments', function () {
    InventoryAdjustment::factory()->count(3)->create([
        'user_id' => $this->user->id,
    ]);

    actingAs($this->user, 'sanctum')
        ->getJson('/api/restify/inventory-adjustments')
        ->assertSuccessful()
        ->assertJsonCount(3, 'data');
});

test('can create a draft inventory adjustment', function () {
    actingAs($this->user, 'sanctum')
        ->postJson('/api/restify/inventory-adjustments', [
            'type' => 'input',
            'description' => 'Initial stock',
            'user_id' => $this->user->id,
        ])
        ->assertCreated()
        ->assertJsonPath('data.attributes.status', 'draft');

    $this->assertDatabaseHas('inventory_adjustments', [
        'type' => 'input',
        'description' => 'Initial stock',
        'status' => 'draft',
    ]);
});

test('can add items to inventory adjustment', function () {
    $adjustment = InventoryAdjustment::factory()->create([
        'user_id' => $this->user->id,
        'status' => 'draft',
    ]);

    actingAs($this->user, 'sanctum')
        ->postJson('/api/restify/inventory-adjustment-items', [
            'adjustment' => $adjustment->id,
            'product' => $this->product->id,
            'quantity' => 10,
        ])
        ->assertCreated();

    $this->assertDatabaseHas('inventory_adjustment_items', [
        'inventory_adjustment_id' => $adjustment->id,
        'product_id' => $this->product->id,
        'quantity' => 10,
    ]);
});

test('can finalize an input adjustment and increase stock', function () {
    $adjustment = InventoryAdjustment::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'input',
        'status' => 'draft',
    ]);

    InventoryAdjustmentItem::factory()->create([
        'inventory_adjustment_id' => $adjustment->id,
        'product_id' => $this->product->id,
        'quantity' => 10,
    ]);

    // Initial stock (assuming 0 or create inventory)
    Inventory::create([
        'product_id' => $this->product->id,
        'current_stock' => 5,
        'min_stock' => 0,
    ]);

    actingAs($this->user, 'sanctum')
        ->postJson("/api/restify/inventory-adjustments/{$adjustment->id}/actions?action=finalize-inventory-adjustment")
        ->assertSuccessful();

    $this->assertDatabaseHas('inventory_adjustments', [
        'id' => $adjustment->id,
        'status' => 'finalized',
    ]);

    $this->assertDatabaseHas('inventories', [
        'product_id' => $this->product->id,
        'current_stock' => 15, // 5 + 10
    ]);

    $this->assertDatabaseHas('inventory_movements', [
        'type' => 'input',
        'quantity' => 10,
        'user_id' => $this->user->id,
    ]);
});

test('can finalize an output adjustment and decrease stock', function () {
    $adjustment = InventoryAdjustment::factory()->create([
        'user_id' => $this->user->id,
        'type' => 'output',
        'status' => 'draft',
    ]);

    InventoryAdjustmentItem::factory()->create([
        'inventory_adjustment_id' => $adjustment->id,
        'product_id' => $this->product->id,
        'quantity' => 5,
    ]);

    Inventory::create([
        'product_id' => $this->product->id,
        'current_stock' => 20,
        'min_stock' => 0,
    ]);

    actingAs($this->user, 'sanctum')
        ->postJson("/api/restify/inventory-adjustments/{$adjustment->id}/actions?action=finalize-inventory-adjustment")
        ->assertSuccessful();

    $this->assertDatabaseHas('inventories', [
        'product_id' => $this->product->id,
        'current_stock' => 15, // 20 - 5
    ]);
});

test('can update inventory adjustment description', function () {
    $adjustment = InventoryAdjustment::factory()->create([
        'user_id' => $this->user->id,
        'status' => 'draft',
    ]);

    actingAs($this->user, 'sanctum')
        ->patchJson("/api/restify/inventory-adjustments/{$adjustment->id}", [
            'description' => 'Updated Description',
        ])
        ->assertSuccessful();

    $this->assertDatabaseHas('inventory_adjustments', [
        'id' => $adjustment->id,
        'description' => 'Updated Description',
    ]);
});
