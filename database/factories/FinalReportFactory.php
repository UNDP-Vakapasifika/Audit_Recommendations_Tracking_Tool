<?php

namespace Database\Factories;

use App\Models\FinalReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FinalReport>
 */
class FinalReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_office' => $this->faker->country,
            'audit_report_title' => $this->faker->sentence,
            'date_of_audit' => $this->faker->date,
            'publication_date' => $this->faker->date,
            'page_par_reference' => $this->faker->sentence,
            'audit_recommendations' => $this->faker->paragraph,
            'classfication' => $this->faker->randomElement(['High', 'Medium', 'Low']),
            'audit_type' => $this->faker->randomElement(['Financial', 'Compliance', 'Investigative']),
            'lead_body' => $this->faker->paragraph,
            'key_issues' => $this->faker->paragraph,
            'acceptance_status' => $this->faker->sentence,
            'current_implementation_status' => $this->faker->sentence,
            'follow_up_date' => $this->faker->date,
            'target_completion_date' => //dates within this month
                $this->faker->dateTimeBetween('now', '+1 month'),
            'recurence' => $this->faker->paragraph,
            'action_plan' => $this->faker->paragraph,
            'responsible_person' => $this->faker->name,
            'sai_confirmation' => $this->faker->sentence,
            'responsible_entity' => $this->faker->sentence,
            'head_of_audited_entity' => $this->faker->name,
            'audited_entity_focal_point' => $this->faker->name,
            'audit_team_lead' => $this->faker->name,
            'summary_of_response' => $this->faker->paragraph,
            'responsible_person_email' => $this->faker->unique()->safeEmail,

        ];
    }
}
