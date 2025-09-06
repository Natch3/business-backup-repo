<?php

namespace Database\Factories\OwnerAdmin;
use App\Models\OwnerAdmin\RegisterBranch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OwnerAdmin\RegisterBranch>
 */
class RegisterBranchFactory extends Factory
{
        protected $model = RegisterBranch::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
            $userIds = [2, 13, 14, 15, 16, 17, 18, 19];
            $businessType = ['Retail','Restaurant','Salon'];
  return [
            'branch_name' => $this->faker->company,
            'business_type' => $this->faker->randomElement($businessType),
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'province' => $this->faker->state,
            'contact_number' => $this->faker->phoneNumber,
            'branch_logo' => null,
            'email' => $this->faker->unique()->safeEmail,
            'id_users' => $this->faker->randomElement($userIds),
            'status' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']),
        ];
    }
}
