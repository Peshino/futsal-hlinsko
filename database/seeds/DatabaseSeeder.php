<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(AbilitySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AbilityRoleSeeder::class);
        $this->call(RoleUserSeeder::class);
        $this->call(SeasonSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(CompetitionStyleSeeder::class);
        $this->call(CompetitionSeeder::class);
        $this->call(RuleSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(GameSeeder::class);
        // $this->call(PlayerSeeder::class);
        // $this->call(GoalSeeder::class);
        // $this->call(CardSeeder::class);
        $this->call(RuleTeamSeeder::class);
        $this->call(PhaseSeeder::class);
        $this->call(PositionSeeder::class);
        // $this->call(OldDbSeeder::class);
    }
}
