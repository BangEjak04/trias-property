<?php

namespace Database\Factories;

use App\Models\Application;
use App\Enums\StatusType;
use App\Enums\PriorityType;
use App\Enums\PaymentMethod;
use App\Enums\ApprovalStatus;
use App\Enums\AkadStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Application>
 */
class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(StatusType::cases());
        $priority = $this->faker->randomElement(PriorityType::cases());

        $data = [
            'applicant_name' => $this->faker->name(),
            'applicant_email' => $this->faker->safeEmail(),
            'applicant_phone' => $this->faker->numerify('8##########'), // 11 digit tanpa +62 karena UI memprefix +62
            'status' => $status,
            'priority' => $priority,
            'developer' => $this->faker->company(),
            'property_name' => 'Cluster ' . $this->faker->city(),
            'property_type' => $this->faker->randomElement(['Tipe 36', 'Tipe 45', 'Tipe 72', 'Ruko']),
            'notes' => $this->faker->sentence(),
            'marketing_agent' => $this->faker->name(),
        ];

        if ($status === StatusType::PROSPECT || $status === StatusType::HOT_PROSPECT) {
            $priceRangeFrom = $this->faker->numberBetween(300, 800) * 1000000;
            $data['price_range_from'] = $priceRangeFrom;
            $data['price_range_to'] = $priceRangeFrom + ($this->faker->numberBetween(50, 200) * 1000000);
        } else {
            // Status USER
            $price = $this->faker->numberBetween(400, 1500) * 1000000;
            $dp = $this->faker->numberBetween(20, 100) * 1000000;
            $loan = $price - $dp;

            $data['property_block'] = $this->faker->lexify('Block ?');
            $data['property_number'] = $this->faker->numerify('No. ##');
            $data['building_area'] = $this->faker->numberBetween(36, 150);
            $data['land_area'] = $this->faker->numberBetween(60, 200);
            $data['price'] = $price;
            $data['down_payment_amount'] = $dp;
            $data['loan_amount'] = $loan;
            $data['payment_method'] = $this->faker->randomElement(PaymentMethod::cases());
            $data['down_payment_date'] = $this->faker->date();
            $data['bank_name'] = $this->faker->randomElement(['Bank Mandiri', 'BRI', 'BNI', 'BTN']);
            $data['document_progress'] = $this->faker->randomElement(['25%', '50%', '75%', '100%']);

            $approvalStatus = $this->faker->randomElement(ApprovalStatus::cases());
            $data['approval_status'] = $approvalStatus;

            if ($approvalStatus === ApprovalStatus::ACCEPTED) {
                $data['credit_approval'] = $loan;
                $data['approval_date'] = $this->faker->date();

                $akadStatus = $this->faker->randomElement(AkadStatus::cases());
                $data['akad_status'] = $akadStatus;

                if ($akadStatus === AkadStatus::SCHEDULED || $akadStatus === AkadStatus::DONE) {
                    $data['akad_scheduled_at'] = $this->faker->dateTimeBetween('now', '+1 month');
                    $data['akad_location'] = 'Kantor Cabang ' . $this->faker->city();
                }
            } elseif ($approvalStatus === ApprovalStatus::REJECTED) {
                $data['akad_status'] = null;
            } else {
                $data['akad_status'] = null;
            }
        }

        return $data;
    }
}
